@extends('layouts.app')
@section('title', 'ویرایش کاربر | کتابستان')

@section('content')
<div class="container section">

    <nav class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">پنل ادمین</a><span>/</span>
        <a href="{{ route('admin.users') }}">کاربران</a><span>/</span>
        <span>ویرایش</span>
    </nav>

    <div class="section-head">
        <div>
            <h2 class="section-title"><span class="dot"></span> ✏️ ویرایش کاربر</h2>
            <p class="section-sub">{{ $user->name }}</p>
        </div>
    </div>

    @if($errors->any())
        <div class="form-error" style="background:var(--coral-l);color:var(--coral-d);padding:14px 18px;border-radius:12px;margin-bottom:20px;font-weight:600;border-right:4px solid var(--coral)">
            ⚠️ {{ $errors->first() }}
        </div>
    @endif

    <div class="edit-profile-main" style="max-width:700px;margin:0 auto;">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="card-panel">
            @csrf
            @method('PUT')

            <h3>اطلاعات کاربر</h3>

            <div class="form-grid">
                <div class="form-group">
                    <label>نام *</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="form-group">
                    <label>ایمیل *</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="form-group">
                    <label>موبایل</label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}">
                </div>
                <div class="form-group">
                    <label>رمز عبور جدید (اختیاری)</label>
                    <input type="password" name="password" placeholder="خالی بگذارید تا تغییر نکند">
                </div>
                <div class="form-group full">
                    <label>بیوگرافی</label>
                    <textarea name="bio">{{ old('bio', $user->bio) }}</textarea>
                </div>
                <div class="form-group full">
                    <label style="display:flex;align-items:center;gap:10px;cursor:pointer;padding:14px 18px;background:var(--paper);border:1.5px solid var(--border);border-radius:12px">
                        <input type="checkbox" name="is_admin" value="1" {{ $user->is_admin ? 'checked' : '' }} style="accent-color:var(--mint);width:20px;height:20px">
                        <span style="font-weight:700">👑 دسترسی ادمین</span>
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-lg">💾 ذخیره تغییرات</button>
                <a href="{{ route('admin.users') }}" class="btn btn-ghost btn-lg">انصراف</a>
            </div>
        </form>
    </div>

</div>
@endsection