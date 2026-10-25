@extends('layouts.app')
@section('title', 'مدیریت سفارش‌ها | کتابستان')

@section('content')
<div class="container section">
    <nav class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">پنل ادمین</a><span>/</span>
        <span>سفارش‌ها</span>
    </nav>

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    <div class="section-head">
        <h2 class="section-title"><span class="dot"></span> 📦 مدیریت سفارش‌ها</h2>
        <p class="section-sub">{{ $orders->count() }} سفارش در سیستم</p>
    </div>

    <div class="admin-table">
        <table>
            <thead>
                <tr>
                    <th>کد سفارش</th>
                    <th>مشتری</th>
                    <th>مبلغ کل</th>
                    <th>تاریخ ثبت</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td><strong style="color:var(--mint-d)">{{ $order->order_code }}</strong></td>
                        <td>{{ $order->user->name }}</td>
                        <td class="table-price">{{ number_format($order->total_price) }} ت</td>
                        <td>{{ $order->created_at->format('Y/m/d H:i') }}</td>
                        <td>
                            @if($order->status === 'pending')
                                <span class="order-badge badge-warn" style="background:#fef3c7;color:#92400e">⏳ در انتظار</span>
                            @elseif($order->status === 'approved')
                                <span class="order-badge badge-success" style="background:#dcfce7;color:#166534">✅ تایید شده</span>
                            @else
                                <span class="order-badge" style="background:#fee2e2;color:#991b1b">❌ رد شده</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <button type="button" class="btn btn-sm btn-ghost" onclick="showOrderDetails('{{ $order->id }}')" title="جزئیات">📋 جزئیات</button>
                                
                                @if($order->status === 'pending')
                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-sm" style="background:var(--mint);color:#fff" title="تایید">✅</button>
                                    </form>
                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-sm" style="background:var(--coral);color:#fff" title="رد">❌</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--muted)">هیچ سفارشی در سیستم ثبت نشده است.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal-overlay" id="orderModal" onclick="closeModal(event)">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3>📋 جزئیات سفارش <span id="modalOrderId"></span></h3>
            <button class="close-btn" onclick="closeModal()">✕</button>
        </div>
        
        <div class="modal-body">
            <div class="modal-customer">
                <div class="mc-row">
                    <span>👤 مشتری:</span>
                    <strong id="modalCustomerName"></strong>
                </div>
                <div class="mc-row">
                    <span>📞 تلفن:</span>
                    <strong id="modalCustomerPhone"></strong>
                </div>
                <div class="mc-row">
                    <span>📍 آدرس:</span>
                    <strong id="modalCustomerAddress"></strong>
                </div>
            </div>

            <h4>📚 کتاب‌های سفارش داده شده:</h4>
            <div class="modal-books" id="modalBooksList"></div>
        </div>

        <div class="modal-footer">
            <div class="modal-total">
                <span>مبلغ کل:</span>
                <strong id="modalTotalPrice"></strong>
            </div>
            <button class="btn btn-ghost" onclick="closeModal()">بستن</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ordersData = @json($orders);

    function showOrderDetails(orderId) {
        const order = ordersData.find(o => o.id == orderId);
        if (!order) return;

        document.getElementById('modalOrderId').textContent = order.order_code;
        document.getElementById('modalCustomerName').textContent = order.user.name;
        document.getElementById('modalCustomerPhone').textContent = order.phone;
        document.getElementById('modalCustomerAddress').textContent = order.address;
        document.getElementById('modalTotalPrice').textContent = toFa(order.total_price.toLocaleString('en-US')) + ' تومان';

        let booksHtml = '';
        order.items.forEach(book => {
            let bg = book.cover ? `url('${book.cover}') center/cover` : 'var(--grad-fresh)';
            booksHtml += `
                <div class="mb-item">
                    <div class="mb-cover" style="background: ${bg}"></div>
                    <div class="mb-info">
                        <div class="mb-title">${book.title}</div>
                        <div class="mb-author">${book.author}</div>
                    </div>
                    <div class="mb-qty">${toFa(book.quantity)} عدد</div>
                    <div class="mb-price">${toFa(book.price.toLocaleString('en-US'))} ت</div>
                </div>
            `;
        });
        document.getElementById('modalBooksList').innerHTML = booksHtml;

        document.getElementById('orderModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('orderModal').classList.remove('active');
        document.body.style.overflow = '';
    }

    function toFa(n){
        return String(n).replace(/\d/g, d => '۰۱۲۳۴۵۶۷۸۹'[d]);
    }
</script>
@endpush