@extends('layouts.app')
@section('title', 'ورود | کتابستان')

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
                به <span class="hl">کتابستان</span> خوش آمدی
            </h1>
            <p class="auth-desc">
                جایی که هر کتاب، یک دنیای تازه است. وارد شو و سفر ادبی خودت رو شروع کن.
            </p>

            <div class="floating-books">
                <div class="float-book" style="background:linear-gradient(160deg,#b91c1c,#d97706);animation-delay:0s">
                    <span>📖</span>
                </div>
                <div class="float-book" style="background:linear-gradient(160deg,#6d28d9,#be185d);animation-delay:.5s">
                    <span>📕</span>
                </div>
                <div class="float-book" style="background:linear-gradient(160deg,#0d9488,#0284c7);animation-delay:1s">
                    <span>📗</span>
                </div>
                <div class="float-book" style="background:linear-gradient(160deg,#d97706,#b91c1c);animation-delay:1.5s">
                    <span>📘</span>
                </div>
                <div class="float-book" style="background:linear-gradient(160deg,#be185d,#6d28d9);animation-delay:2s">
                    <span>📙</span>
                </div>
            </div>

            <div class="auth-quote">
                <div class="quote-mark">"</div>
                <p>کتاب، آینه‌ای است که روح را نشان می‌دهد.</p>
                <span class="quote-author">— صادق هدایت</span>
            </div>
        </div>
    </div>

    <div class="auth-form-wrap">
        <div class="auth-form">
            <div class="form-header">
                <div class="form-icon">🔐</div>
                <h2>ورود به حساب</h2>
                <p>برای ادامه، وارد حساب خود شوید</p>
            </div>

            @if($errors->any())
                <div class="form-error">
                    ⚠️ {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>ایمیل</label>
                    <div class="input-icon">
                        <span class="ico">✉️</span>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="example@email.com" required>
                    </div>
                </div>

                               <div class="form-group">
                    <label>رمز عبور</label>
                    <div class="input-icon" style="position:relative">
                        <span class="ico">🔑</span>
                        <input type="password" name="password" id="loginPassword" placeholder="••••••••" required style="padding-left: 48px !important;">
                        <button type="button" onclick="togglePassword('loginPassword')" style="position:absolute; left:16px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; font-size:1.2rem;">👁️</button>
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember">
                        <input type="checkbox" name="remember">
                        <span>مرا به خاطر بسپار</span>
                    </label>
                    <a href="#" class="forgot">فراموشی رمز؟</a>
                </div>

                <button type="submit" class="btn btn-primary btn-lg auth-btn">
                    📚 ورود به کتابستان
                </button>

                <div class="divider">
                    <span>یا</span>
                </div>

                <a href="{{ route('register') }}" class="btn btn-ghost btn-lg auth-btn">
                    ✨ ساخت حساب جدید
                </a>
            </form>

            <div class="form-footer">
                با ورود، <a href="#">قوانین و مقررات</a> کتابستان را می‌پذیرید.
            </div>
        </div>
    </div>

</div>
@endsection