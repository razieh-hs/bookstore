@extends('layouts.app')
@section('title', 'مدیریت مرجوعی‌ها | کتابستان')

@section('content')
<div class="container section">
    <nav class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">پنل ادمین</a><span>/</span>
        <span>درخواست‌های مرجوعی</span>
    </nav>

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    <div class="section-head">
        <h2 class="section-title"><span class="dot"></span> 🔄 درخواست‌های مرجوعی</h2>
        <p class="section-sub">{{ $returns->count() }} درخواست</p>
    </div>

    <div class="admin-table">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>کاربر</th>
                    <th>کد سفارش</th>
                    <th>تاریخ ثبت</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($returns as $r)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $r->user->name }}</td>
                        <td>{{ $r->order->order_code ?? '—' }}</td>
                        <td>{{ $r->created_at->format('Y/m/d') }}</td>
                        <td>
                            @if($r->status === 'pending')
                                <span class="table-tag" style="background:var(--sun-l);color:#92400e">در انتظار</span>
                            @elseif($r->status === 'approved')
                                <span class="table-tag" style="background:var(--mint-l);color:var(--mint-d)">تایید شده</span>
                            @else
                                <span class="table-tag" style="background:var(--coral-l);color:var(--coral-d)">رد شده</span>
                            @endif
                        </td>
                        <td>
                            <div class="table-actions">
                                <button type="button" class="btn btn-sm btn-ghost" onclick="showReturn({{ $r->id }})">📋 جزئیات</button>
                                <form action="{{ route('admin.returns.status', $r->id) }}" method="POST" style="display:inline-flex;gap:4px">
                                    @csrf
                                    <select name="status" class="sort-box" style="padding:4px 8px;border-radius:6px;border:1px solid var(--border);font-family:inherit;font-size:0.8rem">
                                        <option value="pending" {{ $r->status=='pending'?'selected':'' }}>در انتظار</option>
                                        <option value="approved" {{ $r->status=='approved'?'selected':'' }}>تایید</option>
                                        <option value="rejected" {{ $r->status=='rejected'?'selected':'' }}>رد</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">ثبت</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--muted)">هیچ درخواست مرجوعی ثبت نشده است.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal-overlay" id="returnModal" onclick="closeModal(event)">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3>📋 جزئیات درخواست مرجوعی</h3>
            <button class="close-btn" onclick="closeModal()">✕</button>
        </div>
        <div class="modal-body">
            <div class="modal-customer">
                <div class="mc-row"><span>👤 کاربر:</span><strong id="mUser"></strong></div>
                <div class="mc-row"><span>📦 کد سفارش:</span><strong id="mOrder"></strong></div>
                <div class="mc-row"><span>📅 تاریخ سفارش:</span><strong id="mOrderDate"></strong></div>
                <div class="mc-row"><span>📞 تلفن:</span><strong id="mPhone"></strong></div>
                <div class="mc-row"><span>📍 آدرس:</span><strong id="mAddress"></strong></div>
            </div>

            <h4>📚 کتاب‌های سفارش:</h4>
            <div class="modal-books" id="mBooks"></div>

            <div style="margin-top:20px">
                <h4>💬 دلیل مرجوعی:</h4>
                <div id="mReason" style="padding:14px;background:var(--bg);border-radius:12px;line-height:1.9;color:var(--ink-soft);margin-top:8px"></div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="modal-total">
                <span>مبلغ کل:</span>
                <strong id="mTotal"></strong>
            </div>
            <button class="btn btn-ghost" onclick="closeModal()">بستن</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const returnsData = @json($returns);

    function showReturn(id) {
        const r = returnsData.find(x => x.id == id);
        if (!r) return;

        document.getElementById('mUser').textContent = r.user.name;
        document.getElementById('mOrder').textContent = r.order ? r.order.order_code : '—';
        document.getElementById('mOrderDate').textContent = r.order ? new Date(r.order.created_at).toLocaleDateString('fa-IR') : '—';
        document.getElementById('mPhone').textContent = r.order ? r.order.phone : '—';
        document.getElementById('mAddress').textContent = r.order ? r.order.address : '—';
        document.getElementById('mReason').textContent = r.reason;

        let html = '';
        let total = 0;
        if (r.order && r.order.items) {
            r.order.items.forEach(item => {
                total += item.price * item.quantity;
                const bg = item.cover ? `url('${item.cover}') center/cover` : 'var(--grad-fresh)';
                html += `
                    <div class="mb-item">
                        <div class="mb-cover" style="background:${bg}"></div>
                        <div class="mb-info">
                            <div class="mb-title">${item.title}</div>
                            <div class="mb-author">${item.author}</div>
                        </div>
                        <div class="mb-qty">${toFa(item.quantity)} عدد</div>
                        <div class="mb-price">${toFa(item.price.toLocaleString('en-US'))} ت</div>
                    </div>
                `;
            });
        }
        document.getElementById('mBooks').innerHTML = html || '<p style="color:var(--muted)">کتابی یافت نشد</p>';
        document.getElementById('mTotal').textContent = toFa(total.toLocaleString('en-US')) + ' تومان';

        document.getElementById('returnModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('returnModal').classList.remove('active');
        document.body.style.overflow = '';
    }

    function toFa(n){ return String(n).replace(/\d/g, d => '۰۱۲۳۴۵۶۷۸۹'[d]); }
</script>
@endpush