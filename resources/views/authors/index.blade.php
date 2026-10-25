@extends('layouts.app')
@section('title', 'نویسندگان | کتابستان')

@section('content')
<div class="container section">
    <div class="authors-hero">
        <h1>✍️ نویسندگان کتابستان</h1>
        <p>با بزرگ‌ترین نویسندگان ایرانی و جهانی آشنا شو و آثارشون رو کشف کن</p>
    </div>
    <div class="author-grid">
        @include('partials.author-card-list', ['authors' => $authors])
    </div>
</div>
@endsection