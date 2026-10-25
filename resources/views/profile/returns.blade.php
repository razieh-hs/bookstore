@extends('layouts.app')
@section('title', 'درخواست‌های مرجوعی | کتابستان')

@section('content')
<div class="container section">
    <nav class="breadcrumb">
        <a href="{{ route('home') }}">خانه</a><span>/</span>
        <a href="{{ route('profile.index') }}">پروفایل</a><span>/</span>
        <span>مرجوعی‌ها</span>
    </nav>

    <div class="section-head">
        <h2 class="section-title"><span class="dot"></span> 🔄 درخواست‌های مرجوعی من</h2>
        <a href="{{ route('profile.orders') }}" class="btn btn-ghost">📦 سفارش‌های من</a>
    </div>

    @if($returns->count() > 0)
        <div class="orders-list">
            @foreach($returns as $r)
                <div class="order-card">
                    <div class="order-card-header">
                        <div>
                            <span class="order-id">سفارش {{ $r->order->order_code ?? '#' . $r->order_id }}</span>
                            <span class="order-date">• درخواست: {{ $r->created_at->format('Y/m/d H:i') }}</span>
                        </div>
                        @if($r->status === 'pending')
                            <span class="order-badge badge-warn">⏳ در انتظار بررسی</span>
                        @elseif($r->status === 'approved')
                            <span class="order-badge badge-success">✅ تایید شده</span>
                        @else
                            <span class="order-badge" style="background:var(--coral-l);color:var(--coral-d)">❌ رد شده</span>
                        @endif
                    </div>

                    <div class="order-card-body" style="flex-direction:column;align-items:stretch;gap:20px">

                        @if($r->order)
                        <div>
                            <h4 style="font-size:1rem;color:var(--ink);margin-bottom:12px">📚 کتاب‌های سفارش</h4>
                            <div class="modal-books">
                                @foreach($r->order->items as $item)
                                    <div class="mb-item">
                                        <div class="mb-cover" style="background:{{ $item->cover ? "url('" . asset($item->cover) . "') center/cover" : 'var(--grad-fresh)' }}"></div>
                                        <div class="mb-info">
                                            <div class="mb-title">{{ $item->title }}</div>
                                            <div class="mb-author">{{ $item->author }}</div>
                                        </div>
                                        <div class="mb-qty">{{ $item->quantity }} عدد</div>
                                        <div class="mb-price">{{ number_format($item->price) }} ت</div>
                                    </div>
                                @endforeach
                            </div>
                            <div style="display:flex;gap:32px;flex-wrap:wrap;margin-top:16px;padding-top:16px;border-top:1px dashed var(--border)">
                                <div>
                                    <span class="oi-label">تعداد اقلام</span>
                                    <span class="oi-value">{{ $r->order->items->sum('quantity') }} کتاب</span>
                                </div>
                                <div>
                                    <span class="oi-label">مبلغ کل سفارش</span>
                                    <span class="oi-value price">{{ number_format($r->order->total_price) }} تومان</span>
                                </div>
                                <div>
                                    <span class="oi-label">تاریخ سفارش</span>
                                    <span class="oi-value">{{ $r->order->created_at->format('Y/m/d') }}</span>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div>
                            <span class="oi-label">دلیل مرجوعی</span>
                            <div style="margin-top:6px;padding:14px;background:var(--bg);border-radius:12px;color:var(--ink-soft);line-height:1.8">{{ $r->reason }}</div>
                        </div>

                        @if($r->admin_note)
                            <div style="padding:14px;background:var(--mint-l);border-radius:12px;border-right:4px solid var(--mint)">
                                <span class="oi-label" style="color:var(--mint-d)">💬 یادداشت ادمین</span>
                                <div style="margin-top:6px;color:var(--ink)">{{ $r->admin_note }}</div>
                            </div>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="comments-empty">
            <div class="icon">🔄</div>
            <h3>هنوز درخواست مرجوعی نداری</h3>
            <p style="margin-bottom:16px">از صفحه‌ی سفارش‌ها می‌تونی برای سفارش‌های تاییدشده درخواست مرجوعی ثبت کنی</p>
            <a href="{{ route('profile.orders') }}" class="btn btn-primary">📦 مشاهده سفارش‌ها</a>
        </div>
    @endif
</div>
@endsection