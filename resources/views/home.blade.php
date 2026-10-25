@extends('layouts.app')
@section('title', 'کتابستان | فروشگاه آنلاین کتاب')

@section('content')

<section class="hero">
    <div class="hero-bg">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>
    <div class="container hero-grid">
        <div>
            <div class="hero-badge"><span class="pulse"></span> پیشنهاد کتاب بر اساس سلیقه‌ی شما</div>
            <h1>هر کتاب، <span class="hl">دنیایی تازه</span> پیش روی تو می‌گذارد</h1>
            <p>از رمان‌های کلاسیک جهان تا شعرهای معاصر ایران، از فلسفه تا آشپزی. کتابستان کتابخانه‌ای است که هر وقت اراده کنی، در دسترس توست. سیستمی که ما ساخته‌ایم، بر اساس کتاب‌هایی که دوست داری، کتاب‌های تازه‌ای به تو پیشنهاد می‌دهد که شاید هرگز سراغشان نمی‌رفتی.</p>
            <div class="hero-cta">
                <a href="{{ route('books.index') }}" class="btn btn-primary btn-lg">🔍 نگاهی به کتاب‌ها</a>
                <a href="{{ route('recommendations.index') }}" class="btn btn-warm btn-lg">✨ پیشنهاد برای من</a>
            </div>
            <div class="hero-stats">
                <div class="stat"><div class="num"><span class="c">{{ $booksCount ?? '۱۹۰' }}</span>+</div><div class="lbl">کتاب دستچین‌شده</div></div>
                <div class="stat"><div class="num"><span class="c2">{{ $authorsCount ?? '۷۹' }}</span></div><div class="lbl">نویسنده بزرگ</div></div>
                <div class="stat"><div class="num">۱۲</div><div class="lbl">ژانر متفاوت</div></div>
            </div>
        </div>
        <div class="hero-visual">
            <div class="book-stack">
                <div class="hbook" style="background:linear-gradient(rgba(0,0,0,.35),rgba(0,0,0,.65)),url('{{ asset('images/books/b105.jpg') }}') center/cover">
                    <div class="t">مسخ</div>
                    <div class="a">فرانتس کافکا</div>
                </div>
                <div class="hbook" style="background:linear-gradient(rgba(0,0,0,.35),rgba(0,0,0,.65)),url('{{ asset('images/books/b100.jpg') }}') center/cover">
                    <div class="t">۱۹۸۴</div>
                    <div class="a">جورج اورول</div>
                </div>
                <div class="hbook" style="background:linear-gradient(rgba(0,0,0,.35),rgba(0,0,0,.65)),url('{{ asset('images/books/b106.jpg') }}') center/cover">
                    <div class="t">صد سال تنهایی</div>
                    <div class="a">گابریل گارسیا مارکز</div>
                </div>
                <div class="hbook" style="background:linear-gradient(rgba(0,0,0,.35),rgba(0,0,0,.65)),url('{{ asset('images/books/b102.jpg') }}') center/cover">
                    <div class="t">محاکمه</div>
                    <div class="a">فرانتس کافکا</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div>
                <h2 class="section-title"><span class="dot"></span> چه چیزی می‌خواهی بخوانی؟</h2>
                <p class="section-sub">از هر ژانری که دوست داری، اینجا پیدا می‌کنی</p>
            </div>
        </div>
        <div class="genre-pills">
            @foreach(['📖 رمان','🪶 شعر','✍️ داستان کوتاه','🧠 روانشناسی','🚀 توسعه فردی','🏛️ تاریخ','💭 فلسفه','🛸 علمی-تخیلی','🧸 کودک','🎨 هنر','🧭 سفر','🍳 آشپزی'] as $g)
                <a href="{{ route('books.index') }}?genre={{ trim(explode(' ', $g, 2)[1]) }}" class="pill">{{ $g }}</a>
            @endforeach
        </div>
    </div>
</section>

@include('partials.bookshelf', ['books' => $shelfBooks])

<section class="section" style="padding-top:0">
    <div class="container">
        <div class="reco-banner">
            <div class="inner">
                <div>
                    <h2>✨ کتاب‌هایی که به سلیقه‌ی تو می‌خورند</h2>
                    <p>سیستم پیشنهاد ما، بر اساس ژانر و نویسنده‌هایی که دوست داری، کتاب‌هایی را به تو نشان می‌دهد که احتمالاً از آن‌ها لذت می‌بری.</p>
                    <div class="reco-chips">
                        <span class="reco-chip"><span class="dot"></span>بر اساس ژانر</span>
                        <span class="reco-chip"><span class="dot"></span>بر اساس نویسنده</span>
                        <span class="reco-chip"><span class="dot"></span>بر اساس محتوا</span>
                    </div>
                </div>
                <a href="{{ route('recommendations.index') }}" class="btn btn-primary btn-lg">مشاهده پیشنهادها →</a>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div>
                <h2 class="section-title"><span class="dot"></span> 📚 پرفروش‌ترین‌ها</h2>
            </div>
            <a href="{{ route('books.index') }}" class="btn btn-ghost">مشاهده همه →</a>
        </div>
        <div class="book-grid">
            @include('partials.book-card-list', ['books' => $bestSellers])
        </div>
    </div>
</section>

<section class="section" style="background:linear-gradient(180deg,transparent,var(--paper));">
    <div class="container">
        <div class="section-head">
            <div>
                <h2 class="section-title"><span class="dot"></span> 🆕 تازه‌ها</h2>
            </div>
        </div>
        <div class="book-grid">
            @include('partials.book-card-list', ['books' => $newBooks])
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div>
                <h2 class="section-title"><span class="dot"></span> 🗂️ دسته‌بندی‌ها</h2>
            </div>
        </div>
        <div class="genre-grid">
            @include('partials.genre-tiles')
        </div>
    </div>
</section>

<section class="section" style="background:linear-gradient(180deg,transparent,var(--paper));">
    <div class="container">
        <div class="section-head">
            <div>
                <h2 class="section-title"><span class="dot"></span> ✍️ نویسندگانی که می‌شناسی</h2>
            </div>
            <a href="{{ route('authors.index') }}" class="btn btn-ghost">همه نویسندگان →</a>
        </div>
        <div class="author-grid">
            @include('partials.author-card-list', ['authors' => $topAuthors])
        </div>
    </div>
</section>

@endsection