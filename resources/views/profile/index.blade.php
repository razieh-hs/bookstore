@extends('layouts.app')
@section('title', 'پروفایل من | کتابستان')

@section('content')
<div class="container section">

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="form-error" style="background:var(--coral-l);color:var(--coral-d);padding:14px 18px;border-radius:12px;margin-bottom:20px;font-weight:600;border-right:4px solid var(--coral)">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    <div class="user-header">
        <div class="user-initial-big">{{ mb_substr($user->name, 0, 1) }}</div>
        <div class="user-header-info">
            <h2>{{ $user->name }}</h2>
            <p>{{ $user->email }} • عضویت از {{ $user->created_at ? $user->created_at->diffForHumans() : 'نامشخص' }}</p>
        </div>
        <div class="user-header-actions">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">✏️ ویرایش پروفایل</a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-warm">🚪 خروج</button>
            </form>
        </div>
    </div>

    <div class="dashboard-grid">
        <a href="{{ route('profile.orders') }}" class="stat-card" style="text-decoration:none">
            <div class="ico mint">📚</div>
            <div class="n">{{ $purchasedCount }}</div>
            <div class="l">کتاب خریداری‌شده</div>
        </a>
        <a href="{{ route('profile.comments') }}" class="stat-card" style="text-decoration:none">
            <div class="ico sun">💬</div>
            <div class="n">{{ $commentsCount }}</div>
            <div class="l">نظر ثبت‌شده</div>
        </a>
        <a href="{{ route('profile.returns') }}" class="stat-card" style="text-decoration:none">
            <div class="ico coral">🔄</div>
            <div class="n">{{ $pendingReturns }}</div>
            <div class="l">مرجوعی در انتظار</div>
        </a>
        <a href="{{ route('profile.messages') }}" class="stat-card" style="text-decoration:none">
            <div class="ico grape">📩</div>
            <div class="n">{{ $unreadReplies }}</div>
            <div class="l">پیام پاسخ‌داده‌شده</div>
        </a>
    </div>

    <div class="admin-grid" style="margin-top:30px">
        <a href="{{ route('profile.orders') }}" class="admin-card">
            <div class="admin-card-icon" style="background:var(--grad-cool)">📦</div>
            <h3>سفارش‌های من</h3>
            <p>مشاهده و پیگیری سفارش‌ها</p>
        </a>
        <a href="{{ route('profile.returns') }}" class="admin-card">
            <div class="admin-card-icon" style="background:var(--grad-warm)">🔄</div>
            <h3>درخواست‌های مرجوعی</h3>
            <p>پیگیری وضعیت مرجوعی‌ها</p>
        </a>
        <a href="{{ route('profile.comments') }}" class="admin-card">
            <div class="admin-card-icon" style="background:var(--grad-magic)">💬</div>
            <h3>نظرات من</h3>
            <p>مدیریت نظرات و حذف آن‌ها</p>
        </a>
        <a href="{{ route('profile.messages') }}" class="admin-card">
            <div class="admin-card-icon" style="background:linear-gradient(135deg,#0284c7,#1e3a8a)">📩</div>
            <h3>پیام‌های من</h3>
            <p>مشاهده پاسخ‌های پشتیبانی</p>
        </a>
    </div>

</div>
@endsection