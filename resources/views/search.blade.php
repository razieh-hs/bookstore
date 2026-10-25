@extends('layouts.app')
@section('title', 'جستجو | کتابستان')

@section('content')
<div class="container section">

    <div class="search-hero">
        <h1>🔍 جستجو در کتابستان</h1>
        <form action="{{ route('search.index') }}" method="GET" class="search-hero-form">
            <input type="search" name="q" value="{{ $q }}" placeholder="نام کتاب، نویسنده، ژانر..." autofocus>
            <button type="submit" class="btn btn-primary btn-lg">جستجو</button>
        </form>
    </div>

    @if($q !== '')
        <div style="text-align:center;margin:32px 0 12px">
            <p style="color:var(--ink-soft);font-size:1.05rem">
                نتایج برای: <strong style="color:var(--mint)">«{{ $q }}»</strong>
                — {{ $books->count() + $authors->count() }} نتیجه
            </p>
        </div>

        @if($books->count() > 0 || $authors->count() > 0)

            @if($books->count() > 0)
                <div class="section-head" style="margin-top:40px">
                    <h2 class="section-title"><span class="dot"></span> 📚 کتاب‌ها ({{ $books->count() }})</h2>
                    <a href="{{ route('books.index') }}?q={{ urlencode($q) }}" class="btn btn-ghost btn-sm">مشاهده در فروشگاه</a>
                </div>
                <div class="book-grid">
                    @include('partials.book-card-list', ['books' => $books->take(12)])
                </div>
            @endif

            @if($authors->count() > 0)
                <div class="section-head" style="margin-top:50px">
                    <h2 class="section-title"><span class="dot"></span> ✍️ نویسندگان ({{ $authors->count() }})</h2>
                </div>
                <div class="author-grid">
                    @include('partials.author-card-list', ['authors' => $authors])
                </div>
            @endif

        @else
            <div class="comments-empty" style="margin-top:40px">
                <div class="icon">🔍</div>
                <h3>نتیجه‌ای پیدا نشد</h3>
                <p style="margin-bottom:16px">برای «{{ $q }}» چیزی پیدا نکردیم. جستجوی دیگری امتحان کن.</p>
                <a href="{{ route('books.index') }}" class="btn btn-primary">📚 مشاهده همه کتاب‌ها</a>
            </div>
        @endif
    @else
        <div style="margin-top:40px">
            <h3 style="text-align:center;margin-bottom:20px;color:var(--ink-soft)">✨ پیشنهادهای پرطرفدار</h3>
            <div class="genre-pills" style="justify-content:center">
                @foreach(['رمان','شعر','داستان کوتاه','روانشناسی','توسعه فردی','تاریخ','فلسفه','علمی-تخیلی','کودک و نوجوان','هنر','سفر','آشپزی'] as $g)
                    <a href="{{ route('search.index') }}?q={{ urlencode($g) }}" class="pill">{{ $g }}</a>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection