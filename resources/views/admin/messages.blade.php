@extends('layouts.app')
@section('title', 'پیام‌های پشتیبانی | کتابستان')

@section('content')
<div class="container section">
    <nav class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">پنل ادمین</a><span>/</span>
        <span>پیام‌های پشتیبانی</span>
    </nav>

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    <div class="section-head">
        <h2 class="section-title"><span class="dot"></span> 📩 پیام‌های پشتیبانی</h2>
        <p class="section-sub">{{ $messages->count() }} پیام</p>
    </div>

    <div class="admin-table">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>فرستنده</th>
                    <th>موضوع</th>
                    <th>وضعیت</th>
                    <th>تاریخ</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div>{{ $msg->name }}</div>
                            <div style="font-size:.8rem;color:var(--muted)">{{ $msg->email }}</div>
                        </td>
                        <td>{{ $msg->subject }}</td>
                        <td>
                            @if($msg->status === 'replied')
                                <span class="table-tag" style="background:var(--mint-l);color:var(--mint-d)">✅ پاسخ داده</span>
                            @else
                                <span class="table-tag" style="background:var(--sun-l);color:#92400e">⏳ در انتظار</span>
                            @endif
                        </td>
                        <td>{{ $msg->created_at->format('Y/m/d') }}</td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <button class="btn btn-sm btn-ghost" onclick="showMsg({{ $msg->id }})">👁️ مشاهده</button>
                                <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost" style="color:var(--coral)" onclick="return confirm('حذف شود؟')">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--muted)">هیچ پیامی وجود ندارد.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal-overlay" id="msgModal" onclick="closeModal(event)">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3>📩 مشاهده و پاسخ پیام</h3>
            <button class="close-btn" onclick="closeModal()">✕</button>
        </div>
        <form id="replyForm" method="POST">
            @csrf
            <div class="modal-body">
                <div class="modal-customer">
                    <div class="mc-row"><span>👤 فرستنده:</span><strong id="mSenderName"></strong></div>
                    <div class="mc-row"><span>✉️ ایمیل:</span><strong id="mSenderEmail"></strong></div>
                    <div class="mc-row"><span>📌 موضوع:</span><strong id="mSubject"></strong></div>
                    <div class="mc-row"><span>📅 تاریخ:</span><strong id="mDate"></strong></div>
                </div>

                <h4>📝 متن پیام:</h4>
                <div id="mMessage" style="padding:14px;background:var(--bg);border-radius:12px;line-height:1.9;margin-bottom:20px;white-space:pre-wrap;color:var(--ink-soft)"></div>

                <div id="mExistingReply" style="display:none;padding:14px;background:var(--mint-l);border-radius:12px;margin-bottom:20px;border-right:4px solid var(--mint)">
                    <div style="font-size:.85rem;color:var(--mint-d);font-weight:700;margin-bottom:6px">💬 پاسخ قبلی:</div>
                    <div id="mReplyText" style="line-height:1.9;white-space:pre-wrap"></div>
                </div>

                <div class="form-group">
                    <label>پاسخ شما *</label>
                    <textarea name="admin_reply" id="adminReply" rows="5" required placeholder="پاسخ خود را بنویسید..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">📨 ارسال پاسخ</button>
                <button type="button" class="btn btn-ghost" onclick="closeModal()">بستن</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const messagesData = @json($messages);

    function showMsg(id) {
        const m = messagesData.find(x => x.id == id);
        if (!m) return;

        document.getElementById('replyForm').action = '/admin/messages/' + m.id + '/reply';
        document.getElementById('mSenderName').textContent = m.name;
        document.getElementById('mSenderEmail').textContent = m.email;
        document.getElementById('mSubject').textContent = m.subject;
        document.getElementById('mDate').textContent = new Date(m.created_at).toLocaleDateString('fa-IR');
        document.getElementById('mMessage').textContent = m.message;

        const existingReply = document.getElementById('mExistingReply');
        if (m.admin_reply) {
            existingReply.style.display = 'block';
            document.getElementById('mReplyText').textContent = m.admin_reply;
            document.getElementById('adminReply').value = m.admin_reply;
        } else {
            existingReply.style.display = 'none';
            document.getElementById('adminReply').value = '';
        }

        document.getElementById('msgModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('msgModal').classList.remove('active');
        document.body.style.overflow = '';
    }
</script>
@endpush