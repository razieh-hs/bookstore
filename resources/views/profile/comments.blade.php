@extends('layouts.app')
@section('title', 'نظرات من | کتابستان')

@section('content')
<div class="container section">
    <nav class="breadcrumb">
        <a href="{{ route('home') }}">خانه</a><span>/</span>
        <a href="{{ route('profile.index') }}">پروفایل</a><span>/</span>
        <span>نظرات من</span>
    </nav>

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    <div class="section-head">
        <h2 class="section-title"><span class="dot"></span> 💬 نظرات من</h2>
        <p class="section-sub">{{ $comments->count() }} نظر</p>
    </div>

    @if($comments->count() > 0)
        <div class="comment-list">
            @foreach($comments as $comment)
                <div class="comment-item">
                    <div class="comment-head">
                        <div style="flex:1">
                            <div class="comment-name">
                                @if($comment->book)
                                    <a href="{{ route('books.show', $comment->book->id) }}" style="color:var(--mint-d)">
                                        {{ $comment->book->title }}
                                    </a>
                                @else
                                    <span style="color:var(--muted)">کتاب حذف‌شده</span>
                                @endif
                            </div>
                            <div class="comment-date">{{ $comment->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="comment-stars">
                            @for($i=1; $i<=5; $i++)
                                {{ $i <= $comment->rating ? '★' : '☆' }}
                            @endfor
                        </div>
                    </div>
                    <div class="comment-body">{{ $comment->body }}</div>
                    <div style="display:flex;gap:8px;margin-top:14px">
                        @if($comment->book)
                            <a href="{{ route('books.show', $comment->book->id) }}" class="btn btn-sm btn-ghost">📖 مشاهده کتاب</a>
                        @endif
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('این نظر حذف شود؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-ghost" style="color:var(--coral)">🗑️ حذف</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="comments-empty">
            <div class="icon">💬</div>
            <h3>هنوز نظری ثبت نکردی</h3>
            <p style="margin-bottom:16px">با ثبت نظر، به دیگران در انتخاب کتاب کمک کن</p>
            <a href="{{ route('books.index') }}" class="btn btn-primary">📚 مشاهده کتاب‌ها</a>
        </div>
    @endif
</div>
@endsection