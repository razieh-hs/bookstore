@extends('layouts.app')
@section('title', 'سفارش‌های من | کتابستان')

@section('content')
<div class="container section">
    <nav class="breadcrumb">
        <a href="{{ route('home') }}">خانه</a><span>/</span>
        <a href="{{ route('profile.index') }}">پروفایل</a><span>/</span>
        <span>سفارش‌ها</span>
    </nav>

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="form-error" style="background:var(--coral-l);color:var(--coral-d);padding:14px 18px;border-radius:12px;margin-bottom:20px;font-weight:600;border-right:4px solid var(--coral)">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    <div class="section-head">
        <h2 class="section-title"><span class="dot"></span> 📦 سفارش‌های من</h2>
        <a href="{{ route('profile.returns') }}" class="btn btn-ghost">🔄 درخواست‌های مرجوعی</a>
    </div>

    @if($orders->count() > 0)
        <div class="orders-list">
            @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-card-header">
                        <div>
                            <span class="order-id">سفارش {{ $order->order_code }}</span>
                            <span class="order-date">• {{ $order->created_at->format('Y/m/d H:i') }}</span>
                        </div>

                        @if($order->status === 'pending')
                            <span class="order-badge badge-warn">⏳ در انتظار تایید</span>
                        @elseif($order->status === 'approved')
                            <span class="order-badge badge-success">✅ تایید شد - در حال ارسال</span>
                        @else
                            <span class="order-badge" style="background:var(--coral-l);color:var(--coral-d)">❌ رد شد</span>
                        @endif
                    </div>

                    <div class="order-card-body">
                        <div class="order-info">
                            <div>
                                <span class="oi-label">تعداد اقلام</span>
                                <span class="oi-value">{{ $order->items->sum('quantity') }} کتاب</span>
                            </div>
                            <div>
                                <span class="oi-label">مبلغ کل</span>
                                <span class="oi-value price">{{ number_format($order->total_price) }} تومان</span>
                            </div>
                        </div>

                        <div class="order-actions">
                            <a href="{{ route('profile.orders.detail', $order->id) }}" class="btn btn-primary btn-sm">📋 جزئیات</a>

                            @if($order->returnRequest)
                                @if($order->returnRequest->status === 'pending')
                                    <span class="order-badge badge-warn">🔄 مرجوعی در انتظار</span>
                                @elseif($order->returnRequest->status === 'approved')
                                    <span class="order-badge badge-success">✅ مرجوعی تایید</span>
                                @else
                                    <span class="order-badge" style="background:var(--coral-l);color:var(--coral-d)">❌ مرجوعی رد</span>
                                @endif
                            @elseif($order->status === 'approved')
                                <a href="{{ route('returns.create', $order->id) }}" class="btn btn-warm btn-sm">🔄 درخواست مرجوعی</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="comments-empty">
            <div class="icon">📦</div>
            <h3>هنوز سفارشی ثبت نکردی</h3>
            <a href="{{ route('books.index') }}" class="btn btn-primary">📚 شروع خرید</a>
        </div>
    @endif
</div>
@endsection