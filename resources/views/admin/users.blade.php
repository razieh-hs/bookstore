@extends('layouts.app')
@section('title', 'مدیریت کاربران | کتابستان')

@section('content')
<div class="container section">

    <nav class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">پنل ادمین</a><span>/</span>
        <span>کاربران</span>
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
        <div>
            <h2 class="section-title"><span class="dot"></span> 👥 مدیریت کاربران</h2>
            <p class="section-sub">{{ count($users) }} کاربر ثبت‌شده</p>
        </div>
        <form method="GET" action="{{ route('admin.users') }}" class="admin-search-form">
            <input type="text" name="search" value="{{ $search }}" placeholder="جستجوی نام یا ایمیل...">
            <button type="submit" class="btn btn-primary">🔍</button>
        </form>
    </div>

    <div class="admin-table">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>کاربر</th>
                    <th>ایمیل</th>
                    <th>موبایل</th>
                    <th>نظرات</th>
                    <th>نقش</th>
                    <th>عضویت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px">
                                <div class="user-initial" style="width:36px;height:36px;font-size:1rem">
                                    {{ mb_substr($u->name, 0, 1) }}
                                </div>
                                <span style="font-weight:700">{{ $u->name }}</span>
                            </div>
                        </td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->phone ?? '—' }}</td>
                        <td>{{ $u->comments_count }}</td>
                        <td>
                            @if($u->is_admin)
                                <span class="table-tag admin-tag">👑 ادمین</span>
                            @else
                                <span class="table-tag">کاربر</span>
                            @endif
                        </td>
                        <td>{{ $u->created_at ? $u->created_at->format('Y/m/d') : '—' }}</td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm btn-ghost" title="ویرایش">✏️</a>

                                @if($u->id !== auth()->id())
                                    <form action="{{ route('admin.users.toggleAdmin', $u->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-ghost" title="{{ $u->is_admin ? 'حذف ادمین' : 'ادمین کن' }}">
                                            {{ $u->is_admin ? '⬇️' : '⬆️' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" style="display:inline" onsubmit="return confirm('کاربر «{{ $u->name }}» حذف شود؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-ghost" title="حذف" style="color:var(--coral-d)">🗑️</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:40px;color:var(--muted)">
                            کاربری پیدا نشد
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection