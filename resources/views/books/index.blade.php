@extends('layouts.app')
@section('title', 'همه کتاب‌ها | کتابستان')

@section('content')
<div class="container section">
    <div class="section-head">
        <div>
            <h2 class="section-title"><span class="dot"></span> 📚 همه کتاب‌ها</h2>
            <p class="section-sub">{{ count($books) }} کتاب در دسترس</p>
        </div>
    </div>

    <div class="filters-bar">
        <div class="genre-pills">
            <a href="{{ route('books.index') }}" class="pill {{ !request('genre') ? 'active' : '' }}">همه</a>
            @foreach($genres as $g)
                <a href="{{ route('books.index') }}?genre={{ $g }}" class="pill {{ request('genre') == $g ? 'active' : '' }}">{{ $g }}</a>
            @endforeach
        </div>
    </div>

    @if(count($books) > 0)
        <div class="book-grid">
            @include('partials.book-card-list', ['books' => $books])
        </div>
    @else
        <div style="text-align:center;padding:60px 0">
            <div style="font-size:4rem">📭</div>
            <h3 style="margin-top:16px;font-family:var(--font-title)">کتابی پیدا نشد</h3>
            <p style="color:var(--muted);margin-top:8px">لطفاً فیلتر دیگری امتحان کن</p>
        </div>
    @endif
</div>
@endsection