@extends('layouts.app')
@section('title', $author->name . ' | کتابستان')

@section('content')
@php
$photoUrl = asset("images/authors/{$author->id}.jpg");
$placeholder = asset('images/placeholder-author.svg');
$biography = $author->biography ?? [$author->short_bio ?? ''];
$quotes = $author->quotes ?? [];
$awards = $author->awards ?? [];
$facts = $author->facts ?? [];

$infoItems = array_filter([
    'نام کامل'      => $author->full_name,
    'لقب / تخلص'    => $author->pen_name,
    'پیشه'          => $author->occupation,
    'ژانر اصلی'     => $author->genre,
    'دوره'          => $author->era,
    'تحصیلات'       => $author->education,
    'همسر'          => $author->spouse,
    'ملیت'          => $author->nationality,
    'کشور تولد'     => $author->born_country,
    'کشور فوت'      => $author->died_country,
    'محل دفن'       => $author->burial_place,
]);
@endphp

<div class="container section">
    <div class="profile-hero">
        <div class="profile-cover"></div>
        <div class="profile-body">
            <div class="profile-avatar-lg">
                <img src="{{ $photoUrl }}" alt="{{ $author->name }}" onerror="this.onerror=null;this.src='{{ $placeholder }}'">
            </div>
            <div class="profile-top">
                <div>
                    <div class="profile-name">{{ $author->name }}</div>
                    <div class="profile-handle">{{ $author->role }}</div>
                </div>
            </div>
            <p class="profile-bio">{{ $author->short_bio ?? '' }}</p>

            <div class="profile-stats">
                <div class="ps"><div class="n">{{ $author->works }}</div><div class="l">📚 کتاب</div></div>

                @if($author->born_date || $author->born_city)
                <div class="ps">
                    <div class="n" style="font-size:0.95rem;line-height:1.4;margin-top:8px">
                        {{ $author->born_date ?: '—' }}
                        @if($author->born_city)<br><small style="font-weight:400;color:var(--muted)">{{ $author->born_city }}</small>@endif
                    </div>
                    <div class="l">📅 تولد</div>
                </div>
                @endif

                @if($author->died_date || $author->died_city)
                <div class="ps">
                    <div class="n" style="font-size:0.95rem;line-height:1.4;margin-top:8px">
                        {{ $author->died_date ?: '—' }}
                        @if($author->died_city)<br><small style="font-weight:400;color:var(--muted)">{{ $author->died_city }}</small>@endif
                    </div>
                    <div class="l">⚰️ فوت</div>
                </div>
                @endif
            </div>

            @if(count($infoItems) > 0)
            <div class="author-info-grid">
                @foreach($infoItems as $label => $value)
                    <div class="info-item">
                        <div class="info-label">{{ $label }}</div>
                        <div class="info-value">{{ $value }}</div>
                    </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <div class="tabs">
        <button class="tab active" data-tab="books">📚 کتاب‌ها ({{ count($books) }})</button>
        <button class="tab" data-tab="biography">📖 زندگی‌نامه</button>
        <button class="tab" data-tab="quotes">💬 جملات ({{ count($quotes) }})</button>
    </div>

    <div class="tab-content active" id="tab-books">
        @if(count($books) > 0)
            <div class="book-grid">@include('partials.book-card-list', ['books' => $books])</div>
        @else
            <p style="color:var(--muted)">هنوز کتابی از این نویسنده ثبت نشده.</p>
        @endif
    </div>

    <div class="tab-content" id="tab-biography">
        <div class="biography-panel">
            <div class="bio-header">
                <div class="bio-icon">📖</div>
                <div><h2>زندگی‌نامه‌ی {{ $author->name }}</h2></div>
            </div>
            <div class="bio-content">
                @foreach($biography as $paragraph) <p class="bio-paragraph">{{ $paragraph }}</p> @endforeach
            </div>
        </div>
    </div>

    <div class="tab-content" id="tab-quotes">
        @if(count($quotes) > 0)
            <div class="quotes-grid">
                @foreach($quotes as $q)
                    <div class="quote-card"><div class="q">{{ $q }}</div><div class="a">— {{ $author->name }}</div></div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection