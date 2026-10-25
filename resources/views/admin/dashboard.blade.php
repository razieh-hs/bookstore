@extends('layouts.app')
@section('title', 'پنل مدیریت | کتابستان')

@section('content')
<div class="container section">

    <div class="admin-hero">
        <div class="admin-hero-content">
            <div class="admin-hero-icon">👑</div>
            <div>
                <h1>پنل مدیریت کتابستان</h1>
                <p>خوش آمدی، <strong>{{ auth()->user()->name }}</strong> — اینجا می‌تونی همه چیز رو مدیریت کنی</p>
            </div>
        </div>
    </div>

    <h2 class="section-title" style="margin-top:40px"><span class="dot"></span> 📊 آمار کلی</h2>
    <div class="dashboard-grid" style="margin-top:20px">
        <div class="stat-card">
            <div class="ico mint">📚</div>
            <div class="n">{{ $totalBooks }}</div>
            <div class="l">کل کتاب‌ها</div>
        </div>
        <div class="stat-card">
            <div class="ico coral">✍️</div>
            <div class="n">{{ $totalAuthors }}</div>
            <div class="l">نویسندگان</div>
        </div>
        <div class="stat-card">
            <div class="ico sun">👥</div>
            <div class="n">{{ $totalUsers }}</div>
            <div class="l">کاربران</div>
        </div>
        <div class="stat-card">
            <div class="ico grape">💬</div>
            <div class="n">{{ $totalComments }}</div>
            <div class="l">نظرات</div>
        </div>
    </div>

    <h2 class="section-title" style="margin-top:50px"><span class="dot"></span> ⚡ دسترسی سریع</h2>
    <div class="admin-grid" style="margin-top:20px">

        <a href="{{ route('admin.books') }}" class="admin-card">
            <div class="admin-card-icon" style="background:var(--grad-cool)">📚</div>
            <h3>مدیریت کتاب‌ها</h3>
            <p>مشاهده و فیلتر کتاب‌ها</p>
            <span class="admin-card-count">{{ $totalBooks }} مورد</span>
        </a>

        <a href="{{ route('admin.authors') }}" class="admin-card">
            <div class="admin-card-icon" style="background:var(--grad-warm)">✍️</div>
            <h3>مدیریت نویسندگان</h3>
            <p>مشاهده نویسندگان</p>
            <span class="admin-card-count">{{ $totalAuthors }} مورد</span>
        </a>

        <a href="{{ route('admin.users') }}" class="admin-card">
            <div class="admin-card-icon" style="background:var(--grad-magic)">👥</div>
            <h3>مدیریت کاربران</h3>
            <p>ویرایش، حذف و تغییر نقش</p>
            <span class="admin-card-count">{{ $totalUsers }} مورد</span>
        </a>

        <a href="{{ route('admin.orders') }}" class="admin-card">
            <div class="admin-card-icon" style="background:linear-gradient(135deg,#0284c7,#1e3a8a)">📦</div>
            <h3>مدیریت سفارش‌ها</h3>
            <p>مشاهده و پیگیری سفارش‌ها</p>
            <span class="admin-card-count">{{ $totalOrders }} مورد</span>
        </a>

        <a href="{{ route('admin.returns') }}" class="admin-card">
            <div class="admin-card-icon" style="background:linear-gradient(135deg,#b45309,#78350f)">🔄</div>
            <h3>درخواست‌های مرجوعی</h3>
            <p>بررسی و تایید مرجوعی‌ها</p>
            <span class="admin-card-count">{{ $totalReturns }} در انتظار</span>
        </a>

        <a href="{{ route('admin.comments') }}" class="admin-card">
            <div class="admin-card-icon" style="background:linear-gradient(135deg,#78350f,#b45309)">💬</div>
            <h3>مدیریت نظرات</h3>
            <p>مشاهده و حذف نظرات</p>
            <span class="admin-card-count">{{ $totalComments }} مورد</span>
        </a>

        <a href="{{ route('admin.messages') }}" class="admin-card">
            <div class="admin-card-icon" style="background:linear-gradient(135deg,#78350f,#b45309)">📩</div>
            <h3>پیام‌های پشتیبانی</h3>
            <p>مشاهده پیام‌های فرم تماس با ما</p>
            <span class="admin-card-count">{{ $totalMessages }} مورد</span>
        </a>

        <a href="{{ route('home') }}" class="admin-card">
            <div class="admin-card-icon" style="background:linear-gradient(135deg,#be185d,#6d28d9)">🏠</div>
            <h3>مشاهده سایت</h3>
            <p>رفتن به صفحه اصلی فروشگاه</p>
            <span class="admin-card-count">مشاهده</span>
        </a>

    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-top:50px" class="admin-recent-grid">

        <div class="card-panel">
            <h3>👥 جدیدترین کاربران</h3>
            @forelse($recentUsers as $u)
                <div class="order-item" style="margin-bottom:8px">
                    <div class="user-initial" style="width:36px;height:36px;font-size:1rem">{{ mb_substr($u->name, 0, 1) }}</div>
                    <div style="flex:1">
                        <div class="order-id">{{ $u->name }}</div>
                        <div class="order-date">{{ $u->email }}</div>
                    </div>
                    @if($u->is_admin)
                        <span class="table-tag admin-tag">👑</span>
                    @endif
                </div>
            @empty
                <p style="color:var(--muted)">هنوز کاربری ثبت نشده</p>
            @endforelse
        </div>

        <div class="card-panel">
            <h3>💬 آخرین نظرات</h3>
            @forelse($recentComments as $c)
                <div class="order-item" style="margin-bottom:8px">
                    <div class="user-initial" style="width:36px;height:36px;font-size:1rem">{{ mb_substr($c->user->name, 0, 1) }}</div>
                    <div style="flex:1">
                        <div class="order-id">{{ Str::limit($c->body, 50) }}</div>
                        <div class="order-date">{{ $c->user->name }} • {{ $c->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @empty
                <p style="color:var(--muted)">هنوز نظری ثبت نشده</p>
            @endforelse
        </div>

    </div>

</div>
@endsection