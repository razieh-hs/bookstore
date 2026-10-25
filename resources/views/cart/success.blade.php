@extends('layouts.app')
@section('title', 'ثبت سفارش | کتابستان')

@section('content')
<div class="container section">
    <div class="success-page">
        <div class="success-animation">
            <div class="success-circle">
                <svg viewBox="0 0 100 100" class="check-svg">
                    <circle cx="50" cy="50" r="45" class="check-circle"/>
                    <path d="M 30 50 L 45 65 L 70 38" class="check-mark"/>
                </svg>
            </div>
        </div>

        <h1 class="success-title">🎉 سفارش شما ثبت شد!</h1>
        <p class="success-subtitle">سفارش شما در انتظار تایید مدیر است. پس از تایید، به مرحله ارسال می‌رود.</p>

        <div class="order-info-card">
            <div class="info-row">
                <span class="info-label">کد سفارش</span>
                <span class="info-value code">{{ $code }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">تاریخ</span>
                <span class="info-value">{{ now()->format('Y/m/d') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">وضعیت</span>
                <span class="order-badge badge-warn">⏳ در انتظار تایید</span>
            </div>
        </div>

        <div class="success-actions">
            <a href="{{ route('profile.orders') }}" class="btn btn-primary btn-lg">📦 مشاهده سفارش‌ها</a>
            <a href="{{ route('books.index') }}" class="btn btn-ghost btn-lg">📚 ادامه خرید</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    localStorage.setItem('cart', '[]');
    if(typeof updateCartBadge === 'function') updateCartBadge();
</script>
@endpush