@extends('layouts.app')
@section('title', 'تکمیل سفارش | کتابستان')

@section('content')
<div class="container section">

    <nav class="breadcrumb">
        <a href="{{ route('home') }}">خانه</a><span>/</span>
        <a href="{{ route('cart.index') }}">سبد خرید</a><span>/</span>
        <span>تکمیل سفارش</span>
    </nav>

    <div class="section-head">
        <div>
            <h2 class="section-title"><span class="dot"></span> 💳 تکمیل سفارش</h2>
            <p class="section-sub">اطلاعات ارسال و پرداخت را وارد کنید</p>
        </div>
    </div>

    @if(session('error'))
        <div class="form-error" style="background:var(--coral-l);color:var(--coral-d);padding:14px 18px;border-radius:12px;margin-bottom:20px;font-weight:600;border-right:4px solid var(--coral)">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('cart.pay') }}" method="POST" class="checkout-layout" onsubmit="document.getElementById('cart_data').value = localStorage.getItem('cart');">
        @csrf
        <input type="hidden" name="cart_data" id="cart_data">
        
        <div class="checkout-main">

            <div class="checkout-block">
                <div class="block-header">
                    <div class="block-icon">👤</div>
                    <h3>اطلاعات گیرنده</h3>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>نام و نام خانوادگی *</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}" required>
                    </div>
                    <div class="form-group">
                        <label>شماره موبایل *</label>
                        <input type="tel" name="phone" value="{{ auth()->user()->phone ?? '' }}" placeholder="۰۹۱۲۳۴۵۶۷۸۹" required>
                    </div>
                    <div class="form-group">
                        <label>ایمیل</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" readonly>
                    </div>
                </div>
            </div>

            <div class="checkout-block">
                <div class="block-header">
                    <div class="block-icon">📍</div>
                    <h3>آدرس تحویل</h3>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>استان *</label>
                        <select name="province" required>
                            <option>تهران</option>
                            <option>اصفهان</option>
                            <option>خراسان رضوی</option>
                            <option>فارس</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>شهر *</label>
                        <input type="text" name="city" placeholder="مثلاً: تهران" required>
                    </div>
                    <div class="form-group full">
                        <label>آدرس کامل *</label>
                        <textarea name="address" placeholder="خیابان، کوچه، پلاک، واحد" required></textarea>
                    </div>
                </div>
            </div>

            <div class="checkout-block">
                <div class="block-header">
                    <div class="block-icon">💳</div>
                    <h3>روش پرداخت</h3>
                </div>
                <div class="payment-options">
                    <label class="payment-option">
                        <input type="radio" name="payment" value="online" checked>
                        <div class="payment-card">
                            <div class="pay-icon">🏦</div>
                            <div class="pay-info">
                                <div class="pay-name">پرداخت اینترنتی</div>
                                <div class="pay-desc">با تمام کارت‌های بانکی شتاب</div>
                            </div>
                            <div class="pay-check">✓</div>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        <aside class="checkout-sidebar">
            <div class="order-summary">
                <h3>🧾 خلاصه سفارش</h3>
                <div class="summary-books" id="checkoutBooks"></div>
                <div class="summary-rows">
                    <div class="sum-row total">
                        <span>مبلغ قابل پرداخت</span>
                        <span class="final-price" id="finalPrice">۰ تومان</span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg pay-btn">💳 ثبت سفارش</button>
            </div>
        </aside>
    </form>

</div>
@endsection

@push('scripts')
<script>
    window.allBooks = @json($books);
    
    document.addEventListener('DOMContentLoaded', () => {
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        const container = document.getElementById('checkoutBooks');
        
        if (cart.length === 0) {
            window.location.href = "{{ route('cart.index') }}";
            return;
        }
        
        let html = '';
        let total = 0;
        
        cart.forEach(item => {
            const book = window.allBooks.find(b => b.id === item.id);
            if (!book) return;
            
            total += book.price * item.qty;
            let bg = book.cover ? `url('${book.cover}') center/cover` : 'var(--grad-fresh)';
            
            html += `
                <div class="summary-book">
                    <div class="sb-cover" style="background: ${bg}"></div>
                    <div class="sb-info">
                        <div class="sb-title">${book.title}</div>
                        <div class="sb-author">${toFa(item.qty)} عدد</div>
                    </div>
                    <div class="sb-price">${toFa((book.price * item.qty).toLocaleString('en-US'))}</div>
                </div>
            `;
        });
        container.innerHTML = html;
        document.getElementById('finalPrice').textContent = toFa((total + 45000).toLocaleString('en-US')) + ' تومان';
    });
</script>
@endpush