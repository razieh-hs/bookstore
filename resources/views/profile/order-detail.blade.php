@extends('layouts.app')
@section('title', 'جزئیات سفارش | کتابستان')

@section('content')
<div class="container section">
    <nav class="breadcrumb">
        <a href="{{ route('home') }}">خانه</a><span>/</span>
        <a href="{{ route('profile.index') }}">پروفایل</a><span>/</span>
        <a href="{{ route('profile.orders') }}">سفارش‌ها</a><span>/</span>
        <span>جزئیات</span>
    </nav>

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    <div class="section-head">
        <h2 class="section-title"><span class="dot"></span> 📋 جزئیات سفارش</h2>
        <a href="{{ route('profile.orders') }}" class="btn btn-ghost">← بازگشت</a>
    </div>

    <div class="order-card" style="margin-bottom:24px">
        <div class="order-card-header">
            <div>
                <span class="order-id">{{ $order->order_code }}</span>
                <span class="order-date">• {{ $order->created_at->format('Y/m/d H:i') }}</span>
            </div>
            @if($order->status === 'pending')
                <span class="order-badge badge-warn">⏳ در انتظار تایید</span>
            @elseif($order->status === 'approved')
                <span class="order-badge badge-success">✅ تایید شده</span>
            @else
                <span class="order-badge" style="background:var(--coral-l);color:var(--coral-d)">❌ رد شده</span>
            @endif
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px" class="order-detail-grid">
        <div class="card-panel" style="margin:0">
            <h3 style="font-size:1.1rem;margin-bottom:16px">📍 آدرس تحویل</h3>
            <p style="color:var(--ink-soft);line-height:1.9">{{ $order->address }}</p>
            <div style="margin-top:16px;padding-top:16px;border-top:1px dashed var(--border)">
                <div class="mc-row" style="margin-bottom:8px"><span style="color:var(--muted);min-width:80px">تلفن:</span><strong>{{ $order->phone }}</strong></div>
            </div>
        </div>

        <div class="card-panel" style="margin:0">
            <h3 style="font-size:1.1rem;margin-bottom:16px">💰 خلاصه</h3>
            <div class="mc-row" style="margin-bottom:8px"><span style="color:var(--muted);min-width:100px">تعداد اقلام:</span><strong>{{ $order->items->sum('quantity') }} کتاب</strong></div>
            <div class="mc-row" style="margin-bottom:8px"><span style="color:var(--muted);min-width:100px">تعداد عنوان:</span><strong>{{ $order->items->count() }}</strong></div>
            <div class="mc-row"><span style="color:var(--muted);min-width:100px">مبلغ کل:</span><strong style="font-family:var(--font-title);color:var(--mint);font-size:1.3rem">{{ number_format($order->total_price) }} تومان</strong></div>
        </div>
    </div>

    <div class="card-panel">
        <h3 style="font-size:1.2rem;margin-bottom:20px">📚 کتاب‌های سفارش</h3>
        <div class="modal-books">
            @foreach($order->items as $item)
                <div class="mb-item" style="padding:16px">
                    <div class="mb-cover" style="width:60px;height:80px;background:{{ $item->cover ? "url('" . asset($item->cover) . "') center/cover" : 'var(--grad-fresh)' }}"></div>
                    <div class="mb-info">
                        <div class="mb-title" style="font-size:1rem">{{ $item->title }}</div>
                        <div class="mb-author">{{ $item->author }}</div>
                    </div>
                    <div class="mb-qty">{{ $item->quantity }} عدد</div>
                    <div class="mb-price">{{ number_format($item->price * $item->quantity) }} ت</div>
                </div>
            @endforeach
        </div>
    </div>

    @if($order->returnRequest)
        <div class="card-panel" style="margin-top:24px;border-right:4px solid {{ $order->returnRequest->status === 'approved' ? 'var(--mint)' : ($order->returnRequest->status === 'rejected' ? 'var(--coral)' : 'var(--sun)') }}">
            <h3 style="font-size:1.1rem;margin-bottom:12px">🔄 درخواست مرجوعی</h3>
            <div class="mc-row" style="margin-bottom:8px">
                <span style="color:var(--muted);min-width:100px">وضعیت:</span>
                @if($order->returnRequest->status === 'pending')
                    <span class="order-badge badge-warn">⏳ در انتظار بررسی</span>
                @elseif($order->returnRequest->status === 'approved')
                    <span class="order-badge badge-success">✅ تایید شده</span>
                @else
                    <span class="order-badge" style="background:var(--coral-l);color:var(--coral-d)">❌ رد شده</span>
                @endif
            </div>
            <div style="margin-top:12px">
                <span style="color:var(--muted);font-size:.85rem">دلیل:</span>
                <p style="margin-top:6px;color:var(--ink-soft);line-height:1.9">{{ $order->returnRequest->reason }}</p>
            </div>
            @if($order->returnRequest->admin_note)
                <div style="margin-top:14px;padding:14px;background:var(--mint-l);border-radius:12px">
                    <span style="color:var(--mint-d);font-size:.85rem;font-weight:700">💬 پاسخ ادمین:</span>
                    <p style="margin-top:6px">{{ $order->returnRequest->admin_note }}</p>
                </div>
            @endif
        </div>
    @elseif($order->status === 'approved')
        <div style="margin-top:24px;text-align:center">
            <a href="{{ route('returns.create', $order->id) }}" class="btn btn-warm btn-lg">🔄 درخواست مرجوعی</a>
        </div>
    @endif
</div>
@endsection