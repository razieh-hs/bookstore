@extends('layouts.app')
@section('title', 'پیام‌های من | کتابستان')

@section('content')
<div class="container section">
    <nav class="breadcrumb">
        <a href="{{ route('home') }}">خانه</a><span>/</span>
        <a href="{{ route('profile.index') }}">پروفایل</a><span>/</span>
        <span>پیام‌های من</span>
    </nav>

    <div class="section-head">
        <h2 class="section-title"><span class="dot"></span> 📩 پیام‌های من</h2>
        <a href="{{ route('support.index') }}" class="btn btn-primary btn-sm">✉️ ارسال پیام جدید</a>
    </div>

    @if($messages->count() > 0)
        <div class="orders-list">
            @foreach($messages as $msg)
                <div class="order-card">
                    <div class="order-card-header">
                        <div>
                            <span class="order-id">{{ $msg->subject }}</span>
                            <span class="order-date">• {{ $msg->created_at->format('Y/m/d H:i') }}</span>
                        </div>
                        @if($msg->status === 'replied')
                            <span class="order-badge badge-success">✅ پاسخ داده شده</span>
                        @else
                            <span class="order-badge badge-warn">⏳ در انتظار پاسخ</span>
                        @endif
                    </div>

                    <div class="order-card-body" style="flex-direction:column;align-items:stretch;gap:16px">
                        <div>
                            <div style="font-size:.85rem;color:var(--muted);margin-bottom:6px">📝 پیام شما:</div>
                            <div style="padding:14px;background:var(--bg);border-radius:12px;line-height:1.9;color:var(--ink-soft);white-space:pre-wrap">{{ $msg->message }}</div>
                        </div>

                        @if($msg->status === 'replied' && $msg->admin_reply)
                            <div style="padding:14px;background:var(--mint-l);border-radius:12px;border-right:4px solid var(--mint)">
                                <div style="font-size:.85rem;color:var(--mint-d);font-weight:700;margin-bottom:6px">
                                    💬 پاسخ پشتیبانی
                                    <span style="font-weight:400;color:var(--muted);font-size:.8rem;margin-right:8px">({{ $msg->replied_at?->format('Y/m/d H:i') }})</span>
                                </div>
                                <div style="line-height:1.9;color:var(--ink);white-space:pre-wrap">{{ $msg->admin_reply }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="comments-empty">
            <div class="icon">📩</div>
            <h3>هنوز پیامی ارسال نکردی</h3>
            <p style="margin-bottom:16px">اگه سوالی داری، تیم پشتیبانی آماده‌ی کمکه</p>
            <a href="{{ route('support.index') }}" class="btn btn-primary">✉️ ارسال پیام</a>
        </div>
    @endif
</div>
@endsection