@extends('layouts.app')
@section('title', 'ثبت‌نام | کتابستان')

@section('content')
<div class="auth-page">

    <div class="auth-visual">
        <div class="auth-bg"></div>
        <div class="auth-visual-content">
            <div class="auth-logo">
                <span class="logo-icon">📚</span>
                <span class="logo-text">کتابستان</span>
            </div>

            <h1 class="auth-title">
                عضوی از <span class="hl">خانواده کتاب</span> شو
            </h1>
            <p class="auth-desc">
                با ثبت‌نام در کتابستان، به هزاران کتاب دسترسی پیدا کن و کتاب‌های مورد علاقه‌ات رو کشف کن.
            </p>

            <div class="floating-books">
                <div class="float-book" style="background:linear-gradient(160deg,#b91c1c,#d97706);animation-delay:0s">
                    <span>📚</span>
                </div>
                <div class="float-book" style="background:linear-gradient(160deg,#6d28d9,#be185d);animation-delay:.5s">
                    <span>📖</span>
                </div>
                <div class="float-book" style="background:linear-gradient(160deg,#0d9488,#0284c7);animation-delay:1s">
                    <span>📕</span>
                </div>
                <div class="float-book" style="background:linear-gradient(160deg,#d97706,#b91c1c);animation-delay:1.5s">
                    <span>📗</span>
                </div>
            </div>

            <div class="auth-quote">
                <div class="quote-mark">"</div>
                <p>بهشت را همیشه به شکل یک کتابخانه تصور کرده‌ام.</p>
                <span class="quote-author">— خورخه لوئیس بورخس</span>
            </div>
        </div>
    </div>

    <div class="auth-form-wrap">
        <div class="auth-form">
            <div class="form-header">
                <div class="form-icon">✨</div>
                <h2>ساخت حساب جدید</h2>
                <p>در چند ثانیه عضو کتابستان شوید</p>
            </div>

            @if($errors->any())
                <div class="form-error">
                    ⚠️ {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>نام و نام خانوادگی</label>
                    <div class="input-icon">
                        <span class="ico">👤</span>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="مثلاً: علی محمدی" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>ایمیل</label>
                    <div class="input-icon">
                        <span class="ico">✉️</span>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="example@email.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>رمز عبور</label>
                    <div class="input-icon">
                        <span class="ico">🔑</span>
                        <input type="password" name="password" placeholder="حداقل ۶ کاراکتر" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>تکرار رمز عبور</label>
                    <div class="input-icon">
                        <span class="ico">🔒</span>
                        <input type="password" name="password_confirmation" placeholder="رمز را دوباره وارد کنید" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg auth-btn">
                    🎉 ساخت حساب
                </button>

                <div class="divider">
                    <span>قبلاً عضو شدی؟</span>
                </div>

                <a href="{{ route('login') }}" class="btn btn-ghost btn-lg auth-btn">
                    🔐 ورود به حساب
                </a>
            </form>

            <div class="form-footer">
                با ثبت‌نام، <a href="#">قوانین و مقررات</a> کتابستان را می‌پذیرید.
            </div>
        </div>
    </div>

</div>
@endsection