@extends('layouts.app')
@section('title', 'درخواست مرجوعی | کتابستان')

@section('content')
<div class="container section">
    <nav class="breadcrumb">
        <a href="{{ route('home') }}">خانه</a><span>/</span>
        <a href="{{ route('profile.orders') }}">سفارش‌های من</a><span>/</span>
        <span>درخواست مرجوعی</span>
    </nav>

    <div class="section-head">
        <h2 class="section-title"><span class="dot"></span> 🔄 درخواست مرجوعی</h2>
    </div>

    @if(session('error'))
        <div class="form-error">⚠️ {{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="form-error">⚠️ {{ $errors->first() }}</div>
    @endif

    <div style="max-width:700px;margin:0 auto">
        <div class="card-panel" style="margin-bottom:20px">
            <h3>اطلاعات سفارش</h3>
            <div class="info-row"><span class="info-label">کد سفارش</span><span class="info-value code">{{ $order->order_code }}</span></div>
            <div class="info-row"><span class="info-label">تاریخ سفارش</span><span class="info-value">{{ $order->created_at->format('Y/m/d') }}</span></div>
            <div class="info-row"><span class="info-label">مبلغ کل</span><span class="info-value price">{{ number_format($order->total_price) }} تومان</span></div>
            <div class="info-row"><span class="info-label">تعداد اقلام</span><span class="info-value">{{ $order->items->sum('quantity') }} کتاب</span></div>
        </div>

        <form action="{{ route('returns.store') }}" method="POST" class="card-panel">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">

            <h3>دلیل مرجوعی</h3>
            <div class="form-group">
                <label>لطفاً دلیل خود را با جزئیات بنویسید *</label>
                <textarea name="reason" rows="6" placeholder="مثلاً: کتاب آسیب‌دیده به دستم رسید، یا با توضیحات سایت مغایرت داشت..." required minlength="10">{{ old('reason') }}</textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-lg">📨 ثبت درخواست</button>
                <a href="{{ route('profile.orders') }}" class="btn btn-ghost btn-lg">انصراف</a>
            </div>
        </form>
    </div>
</div>
@endsection