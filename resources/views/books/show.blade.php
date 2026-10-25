@extends('layouts.app')
@section('title', $book->title . ' | کتابستان')

@php
$grads = [
  'رمان'=>'linear-gradient(160deg,#b91c1c,#d97706)','شعر'=>'linear-gradient(160deg,#6d28d9,#be185d)','داستان کوتاه'=>'linear-gradient(160deg,#0d9488,#0284c7)',
  'روانشناسی'=>'linear-gradient(160deg,#0284c7,#6d28d9)','توسعه فردی'=>'linear-gradient(160deg,#d97706,#b91c1c)','تاریخ'=>'linear-gradient(160deg,#78350f,#b45309)',
  'فلسفه'=>'linear-gradient(160deg,#1c1917,#57534e)','علمی-تخیلی'=>'linear-gradient(160deg,#0284c7,#1e3a8a)','کودک و نوجوان'=>'linear-gradient(160deg,#d97706,#be185d)',
  'هنر'=>'linear-gradient(160deg,#be185d,#6d28d9)','سفر'=>'linear-gradient(160deg,#0d9488,#d97706)','آشپزی'=>'linear-gradient(160deg,#c2410c,#d97706)',
];
$hasCover = !empty($book->cover);
$grad = $grads[$book->genre] ?? 'linear-gradient(160deg,#0d9488,#0284c7)';
$coverUrl = $hasCover ? asset($book->cover) : null;
$bg = $hasCover ? "linear-gradient(180deg,rgba(0,0,0,.3),rgba(0,0,0,.7)), url('{$coverUrl}') center/cover no-repeat" : $grad;
@endphp

@section('content')
<div class="container section">
    <nav class="breadcrumb">
        <a href="{{ route('home') }}">خانه</a><span>/</span>
        <a href="{{ route('books.index') }}">کتاب‌ها</a><span>/</span>
        <span>{{ $book->genre }}</span><span>/</span>
        <span>{{ $book->title }}</span>
    </nav>

    <div class="detail-grid">
        <div class="detail-cover" style="background:{{ $bg }}">
            <div class="cgenre">{{ $book->genre }}</div>
            <div>
                <div class="ct">{{ $book->title }}</div>
                <div class="ca">{{ $book->author->name ?? 'ناشناس' }}</div>
            </div>
        </div>

        <div class="detail-info">
            <h1>{{ $book->title }}</h1>
            <div class="detail-author-line">
                نوشته <a href="{{ route('authors.show', $book->author_id) }}">{{ $book->author->name ?? 'ناشناس' }}</a>
                &nbsp;•&nbsp; {{ $book->publisher }} &nbsp;•&nbsp; {{ $book->year ?: '—' }}
            </div>

            <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;margin-bottom:20px">
                <div class="stars">
                    @for($i=1;$i<=5;$i++) <span class="{{ $i <= round($avgRating) ? '' : 'off' }}">★</span> @endfor
                </div>
                <b>{{ number_format($avgRating, 1) }}</b>
                <span style="color:var(--muted)">({{ $commentCount }} نظر)</span>
            </div>

            <div class="detail-meta-grid">
                <div class="meta-item"><div class="k">تعداد صفحات</div><div class="v">{{ $book->pages }} صفحه</div></div>
                <div class="meta-item"><div class="k">سال انتشار</div><div class="v">{{ $book->year ?: '—' }}</div></div>
                <div class="meta-item"><div class="k">ناشر</div><div class="v">{{ $book->publisher }}</div></div>
                <div class="meta-item"><div class="k">ژانر</div><div class="v">{{ $book->genre }}</div></div>
            </div>

            <p class="detail-desc">{{ $book->desc }}</p>

            <div class="price-box">
                <div>
                    @if($book->old) <div class="old">{{ number_format($book->old) }} تومان</div> @endif
                    <div class="p">{{ number_format($book->price) }}<small> تومان</small></div>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap">
                    <button class="btn btn-primary btn-lg" onclick="addToCart('{{ $book->id }}')">🛒 افزودن به سبد</button>
                    <button class="btn btn-warm btn-lg" onclick="toggleWishlist('{{ $book->id }}')">❤️</button>
                </div>
            </div>

            <div class="tabs">
                <button class="tab active" data-tab="desc">توضیحات</button>
                <button class="tab" data-tab="similar">کتاب‌های مشابه</button>
                <button class="tab" data-tab="comments">💬 نظرات ({{ $commentCount }})</button>
            </div>

            <div class="tab-content active" id="tab-desc">
                <div class="book-full-desc">
                    @if($book->desc_long)
                        @foreach(explode("\n\n", $book->desc_long) as $paragraph) <p class="desc-paragraph">{{ $paragraph }}</p> @endforeach
                    @else
                        <p class="desc-paragraph">{{ $book->desc }}</p>
                    @endif
                </div>
            </div>

            <div class="tab-content" id="tab-similar">
                <div class="book-grid">@include('partials.book-card-list', ['books' => $similar])</div>
            </div>

            <div class="tab-content" id="tab-comments">
                <div class="comments-section">
                    @auth
                        <div class="comment-form-card">
                            <h3>✍️ نظر خودت را بنویس</h3>
                            <form action="{{ route('comments.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <div class="form-group">
                                    <label>امتیاز تو</label>
                                    <div class="rating-input">
                                        @for($i=5; $i>=1; $i--)
                                            <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }}>
                                            <label for="star{{ $i }}">★</label>
                                        @endfor
                                    </div>
                                </div>
                                <div class="form-group"><label>نظرت درباره این کتاب</label><textarea name="body" placeholder="این کتاب را چطور دیدی؟" required></textarea></div>
                                <button type="submit" class="btn btn-primary">📝 ثبت نظر</button>
                            </form>
                        </div>
                    @else
                        <div class="comments-empty">
                            <div class="icon">🔒</div><h3>برای ثبت نظر وارد شو</h3>
                            <a href="{{ route('login') }}" class="btn btn-primary">🔐 ورود به حساب</a>
                        </div>
                    @endauth

                    @if($comments->count() > 0)
                        <div class="comment-list">
                            @foreach($comments as $comment)
                                <div class="comment-item">
                                    <div class="comment-head">
                                        <div class="comment-avatar">{{ mb_substr($comment->user->name, 0, 1) }}</div>
                                        <div class="comment-meta"><div class="comment-name">{{ $comment->user->name }}</div><div class="comment-date">{{ $comment->created_at->diffForHumans() }}</div></div>
                                        <div class="comment-stars">@for($i=1; $i<=5; $i++) {{ $i <= $comment->rating ? '★' : '☆' }} @endfor</div>
                                    </div>
                                    <div class="comment-body">{{ $comment->body }}</div>
                                    @auth
                                        @if(auth()->id() === $comment->user_id || auth()->user()->is_admin)
                                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="margin-top:12px">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-ghost" onclick="return confirm('این نظر حذف شود؟')">🗑️ حذف</button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="comments-empty"><div class="icon">💬</div><h3>هنوز نظری ثبت نشده</h3></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection