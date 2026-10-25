@extends('layouts.app')
@section('title', 'مدیریت نظرات | کتابستان')

@section('content')
<div class="container section">

    <nav class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">پنل ادمین</a><span>/</span>
        <span>نظرات</span>
    </nav>

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    <div class="section-head">
        <div>
            <h2 class="section-title"><span class="dot"></span> 💬 مدیریت نظرات</h2>
            <p class="section-sub">{{ count($comments) }} نظر ثبت‌شده</p>
        </div>
    </div>

    @if($comments->count() > 0)
        <div class="comment-list">
            @foreach($comments as $c)
                @php $book = $books[$c->book_id] ?? null; @endphp
                <div class="comment-item">
                    <div class="comment-head">
                        <div class="user-initial" style="width:44px;height:44px;font-size:1.2rem">
                            {{ mb_substr($c->user->name, 0, 1) }}
                        </div>
                        <div class="comment-meta">
                            <div class="comment-name">{{ $c->user->name }}</div>
                            <div class="comment-date">
                                @if($book)
                                    درباره‌ی <a href="{{ route('books.show', $book['id']) }}" style="color:var(--mint-d)">{{ $book['title'] }}</a>
                                @else
                                    کتاب حذف‌شده
                                @endif
                                • {{ $c->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <div class="comment-stars">
                            @for($i=1; $i<=5; $i++)
                                {{ $i <= $c->rating ? '★' : '☆' }}
                            @endfor
                        </div>
                    </div>
                    <div class="comment-body">{{ $c->body }}</div>

                    <form action="{{ route('admin.comments.destroy', $c->id) }}" method="POST" style="margin-top:12px">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-ghost" onclick="return confirm('این نظر حذف شود؟')">🗑️ حذف نظر</button>
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <div class="comments-empty">
            <div class="icon">💬</div>
            <h3>هنوز نظری ثبت نشده</h3>
        </div>
    @endif

</div>
@endsection