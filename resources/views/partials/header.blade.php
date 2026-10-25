<header class="header">
    <div class="container header-inner">
        <a href="{{ route('home') }}" class="logo">
            <span class="icon">📚</span>
            <span>کتابستان</span>
        </a>

        <nav class="nav">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">خانه</a>
            <a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.*') ? 'active' : '' }}">کتاب‌ها</a>
            <a href="{{ route('authors.index') }}" class="{{ request()->routeIs('authors.*') ? 'active' : '' }}">نویسندگان</a>
            <a href="{{ route('recommendations.index') }}" class="{{ request()->routeIs('recommendations.*') ? 'active' : '' }}">✨ پیشنهاد</a>
            <a href="{{ route('support.index') }}" class="{{ request()->routeIs('support.*') ? 'active' : '' }}">پشتیبانی</a>
        </nav>

        <form action="{{ route('search.index') }}" method="GET" class="header-search">
            <span class="ico">🔍</span>
            <input type="search" name="q" value="{{ request('q') }}" placeholder="جستجوی کتاب، نویسنده...">
        </form>

        <div class="header-actions">
            <a href="{{ route('cart.index') }}" class="icon-btn" title="سبد خرید">
                🛒<span class="badge-count" id="cartCount">۰</span>
            </a>

            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="icon-btn admin-btn" title="پنل ادمین">👑</a>
                @endif

                <div class="user-menu">
                    <button class="user-toggle">
                        <span class="user-initial">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
                        <span class="user-name">{{ auth()->user()->name }}</span>
                    </button>

                   <div class="user-dropdown">
    <div class="ud-header">
        <strong>{{ auth()->user()->name }}</strong>
        <small>{{ auth()->user()->email }}</small>
        @if(auth()->user()->is_admin)
            <span class="ud-badge">👑 ادمین</span>
        @endif
    </div>
    <a href="{{ route('profile.index') }}">👤 پروفایل من</a>
    <a href="{{ route('profile.orders') }}">📦 سفارش‌های من</a>
    <a href="{{ route('profile.returns') }}">🔄 مرجوعی‌های من</a>
    <a href="{{ route('profile.comments') }}">💬 نظرات من</a>
    <a href="{{ route('profile.messages') }}">📩 پیام‌های من</a>
    <a href="{{ route('profile.edit') }}">✏️ ویرایش پروفایل</a>
    @if(auth()->user()->is_admin)
        <a href="{{ route('admin.dashboard') }}">👑 پنل ادمین</a>
    @endif
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-btn">🚪 خروج</button>
    </form>
</div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">🔐 ورود</a>
                <a href="{{ route('register') }}" class="btn btn-ghost btn-sm">✨ ثبت‌نام</a>
            @endauth
        </div>
    </div>
</header>