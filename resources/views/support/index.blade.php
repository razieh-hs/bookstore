@extends('layouts.app')
@section('title', 'پشتیبانی | کتابستان')

@section('content')
<div class="container section">
    <div class="support-hero">
        <h1>👋 چطور می‌تونیم کمکت کنیم؟</h1>
        <p>تیم پشتیبانی کتابستان ۲۴ ساعته آماده پاسخگویی به سوالات توئه.</p>
        <div class="support-search">
            <input type="search" placeholder="سوالت رو جستجو کن..." id="faqSearch" onkeyup="searchFaq()">
        </div>
    </div>

    <div class="support-grid">
        <div class="support-card">
            <div class="ico">💬</div>
            <h3>گفتگوی آنلاین</h3>
            <p>با کارشناسان ما آنلاین صحبت کن</p>
            <button onclick="toast('به زودی به کارشناس وصل می‌شید...')" class="btn btn-primary btn-sm">شروع گفتگو</button>
        </div>
        <div class="support-card">
            <div class="ico">📞</div>
            <h3>تماس تلفنی</h3>
            <p>۰۲۱-۹۱۰۰۰۰۰۰ (۲۴ ساعته)</p>
            <a href="tel:02191000000" class="btn btn-primary btn-sm">تماس بگیر</a>
        </div>
        <div class="support-card">
            <div class="ico">✉️</div>
            <h3>ایمیل</h3>
            <p>support@ketabestan.ir</p>
            <a href="mailto:support@ketabestan.ir" class="btn btn-primary btn-sm">ارسال ایمیل</a>
        </div>
        <div class="support-card">
            <div class="ico">📋</div>
            <h3>پیگیری سفارش</h3>
            <p>وضعیت سفارشت رو چک کن</p>
            <a href="{{ route('profile.orders') }}" class="btn btn-primary btn-sm">پیگیری</a>
        </div>
    </div>

    <h2 class="section-title" id="faq" style="margin-bottom:20px"><span class="dot"></span> سوالات متداول</h2>

    <div class="faq-list" id="faqList">
        @foreach([
            ['چطور سفارشم رو پیگیری کنم؟','از طریق پنل کاربری، بخش سفارش‌های من، وضعیت لحظه‌ای سفارشت رو ببین. کد رهگیری هم پیامک می‌شه.'],
            ['ارسال چقدر طول می‌کشه؟','در تهران ۲۴ ساعت، سایر شهرها ۲ تا ۵ روز کاری.'],
            ['امکان مرجوعی وجود داره؟','تا ۷ روز پس از دریافت، اگر راضی نبودی می‌تونی از بخش سفارش‌های من مرجوع کنی.'],
            ['سیستم توصیه‌گر چطور کار می‌کنه؟','با تحلیل محتوای کتاب‌ها (ژانر، توضیحات، نویسنده) و رفتار مطالعه تو، کتاب‌های مشابه رو پیشنهاد می‌ده.'],
            ['پرداخت امن هست؟','بله، تمام تراکنش‌ها با رمزنگاری SSL انجام می‌شه.'],
            ['کتاب‌ها اورجینال هستن؟','بله، تمام کتاب‌ها از ناشران معتبر تأمین می‌شن.'],
        ] as $i => $faq)
            <div class="faq-item {{ $i == 0 ? 'open' : '' }}">
                <div class="faq-q"><span>{{ $faq[0] }}</span><span class="chev">▼</span></div>
                <div class="faq-a">{{ $faq[1] }}</div>
            </div>
        @endforeach
    </div>

        <h2 class="section-title" id="contact" style="margin:40px 0 20px"><span class="dot"></span> تماس با ما</h2>
    <div class="card-panel">
        @if(session('success'))
            <div class="alert-success">✅ {{ session('success') }}</div>
        @endif

        <form action="{{ route('support.store') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div class="form-group"><label>نام</label><input type="text" name="name" placeholder="نام شما" required></div>
                <div class="form-group"><label>ایمیل</label><input type="email" name="email" placeholder="example@email.com" required></div>
                <div class="form-group full"><label>موضوع</label><input type="text" name="subject" placeholder="موضوع پیام" required></div>
                <div class="form-group full"><label>پیام شما</label><textarea name="message" placeholder="پیامت رو بنویس..." required></textarea></div>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">📨 ارسال پیام</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function searchFaq() {
        const query = document.getElementById('faqSearch').value.trim().toLowerCase();
        const items = document.querySelectorAll('#faqList .faq-item');

        items.forEach(item => {
            const text = item.innerText.toLowerCase();
            if (text.includes(query)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }
</script>
@endpush