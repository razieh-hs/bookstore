@extends('layouts.app')
@section('title', 'پیشنهاد هوشمند | کتابستان')

@section('content')
<div class="container section">
    <div class="reco-banner" style="margin-bottom:40px">
        <div class="inner">
            <div>
                <h2>🤖 سیستم توصیه‌گر یادگیری ماشین</h2>
                <p>با تحلیل محتوای کتاب‌هایی که خوندی (ژانر، توضیحات، نویسنده) و رفتار مطالعاتی تو، کتاب‌هایی رو پیدا می‌کنیم که بیشترین شباهت رو دارن.</p>
                <div class="reco-chips">
                    <span class="reco-chip"><span class="dot"></span>TF-IDF + Cosine Similarity</span>
                    <span class="reco-chip"><span class="dot"></span>Content-Based Filtering</span>
                    <span class="reco-chip"><span class="dot"></span>تحلیل {{ $books->count() }} کتاب</span>
                </div>
            </div>
        </div>
    </div>

    <h2 class="section-title" style="margin-bottom:20px"><span class="dot"></span> 📚 بر اساس کتاب‌هایی که خوندی</h2>
    <div class="book-grid">
        @include('partials.book-card-list', ['books' => $books->slice(0, 5)])
    </div>

    <h2 class="section-title" style="margin:40px 0 20px"><span class="dot"></span> ✨ شاید این‌ها رو هم دوست داشته باشی</h2>
    <div class="book-grid">
        @include('partials.book-card-list', ['books' => $books->slice(5, 5)])
    </div>

    <h2 class="section-title" style="margin:40px 0 20px"><span class="dot"></span> 🔥 بر اساس ژانرهای محبوب تو</h2>
    <div class="book-grid">
        @include('partials.book-card-list', ['books' => $books->slice(10, 5)])
    </div>
</div>
@endsection