@extends('layouts.app')
@section('title', 'ویرایش پروفایل | کتابستان')

@section('content')
<div class="container section">

    <nav class="breadcrumb">
        <a href="{{ route('home') }}">خانه</a><span>/</span>
        <a href="{{ route('profile.index') }}">پروفایل</a><span>/</span>
        <span>ویرایش</span>
    </nav>

    <div class="section-head">
        <div>
            <h2 class="section-title"><span class="dot"></span> ✏️ ویرایش پروفایل</h2>
            <p class="section-sub">اطلاعات شخصی خود را به‌روز کنید</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="form-error">⚠️ {{ $errors->first() }}</div>
    @endif

    <div class="edit-profile-layout">

        <aside class="profile-sidebar">
            <div class="sidebar-avatar">
                <div class="user-initial-big sidebar-initial">
                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                </div>
                <div style="font-weight:700;margin-bottom:8px;text-align:center">{{ auth()->user()->name }}</div>
                <div style="text-align:center;color:var(--muted);font-size:.82rem">{{ auth()->user()->email }}</div>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('profile.index') }}">👤 پروفایل من</a>
                <a href="{{ route('profile.edit') }}" class="active">✏️ ویرایش پروفایل</a>
                <a href="{{ route('profile.orders') }}">📦 سفارش‌های من</a>
            </nav>
        </aside>

        <main class="edit-profile-main">
            <form action="{{ route('profile.update') }}" method="POST" class="card-panel">
                @csrf

                <h3>اطلاعات شخصی</h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label>نام و نام خانوادگی *</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label>ایمیل *</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                    </div>
                    <div class="form-group">
                        <label>شماره موبایل</label>
                        <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}">
                    </div>
                    <div class="form-group full">
                        <label>بیوگرافی</label>
                        <textarea name="bio" placeholder="درباره خودت بنویس...">{{ old('bio', auth()->user()->bio) }}</textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-lg">💾 ذخیره تغییرات</button>
                    <a href="{{ route('profile.index') }}" class="btn btn-ghost btn-lg">انصراف</a>
                </div>
            </form>
        </main>

    </div>

</div>
@endsection