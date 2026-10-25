@extends('layouts.app')
@section('title', 'سبد خرید | کتابستان')

@section('content')
<div class="container section">
    <div class="section-head">
        <div>
            <h2 class="section-title"><span class="dot"></span> 🛒 سبد خرید</h2>
            <p class="section-sub" id="cartSubtitle">در حال بارگذاری...</p>
        </div>
    </div>

    @if(session('error'))
        <div class="form-error" style="background:var(--coral-l);color:var(--coral-d);padding:14px 18px;border-radius:12px;margin-bottom:20px;font-weight:600;border-right:4px solid var(--coral)">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    <div class="cart-layout" id="cartLayout" style="display:none;">
        <div id="cartItemsContainer"></div>

        <div class="cart-summary">
            <h3>خلاصه سفارش</h3>
            <div class="sum-row"><span>جمع کل کتاب‌ها</span><span id="cartTotal">۰ تومان</span></div>
            <div class="sum-row"><span>هزینه ارسال</span><span>۴۵,۰۰۰ تومان</span></div>
            <div class="sum-row total"><span>مبلغ نهایی</span><span class="v" id="finalTotal">۰ تومان</span></div>
            <a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-lg" style="width:100%;margin-top:20px">💳 تکمیل خرید</a>
            <a href="{{ route('books.index') }}" class="btn btn-ghost" style="width:100%;margin-top:10px">ادامه خرید</a>
        </div>
    </div>

    <div class="comments-empty" id="emptyCart" style="display:none;">
        <div class="icon">🛒</div>
        <h3>سبد خرید شما خالی است</h3>
        <p style="margin-bottom:16px">هنوز هیچ کتابی به سبد اضافه نکردی.</p>
        <a href="{{ route('books.index') }}" class="btn btn-primary">📚 رفتن به فروشگاه</a>
    </div>

</div>
@endsection

@push('scripts')
<script>
    window.allBooks = @json($books);
</script>
@endpush