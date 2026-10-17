<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') | Lost & Found</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="admin-body">

    <!-- ===== SIDEBAR NAVBAR (fixed on the left) ===== -->
    <aside class="sidebar">
        <div class="sidebar__brand"><i data-lucide="shield-check"></i> Admin</div>

        <nav class="sidebar__links">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i data-lucide="layout-dashboard"></i> Dashboard
            </a>
            <a href="{{ route('admin.items') }}" class="{{ request()->routeIs('admin.items') ? 'active' : '' }}">
                <i data-lucide="package"></i> Items
            </a>
            <a href="{{ route('admin.claims') }}" class="{{ request()->routeIs('admin.claims*') ? 'active' : '' }}">
                <i data-lucide="clipboard-check"></i> Claims
            </a>
            <a href="{{ route('items.index') }}">
                <i data-lucide="external-link"></i> View Site
            </a>
        </nav>

        <form method="POST" action="{{ route('logout') }}" class="sidebar__logout">
            @csrf
            <button><i data-lucide="log-out"></i> Logout</button>
        </form>
    </aside>

    <!-- ===== PAGE CONTENT ===== -->
    <main class="admin-main">
        @if (session('success'))
            <div class="alert"><i data-lucide="check-circle"></i> {{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert--error"><i data-lucide="alert-circle"></i> {{ $errors->first() }}</div>
        @endif

        @yield('content')
    </main>

    <script>lucide.createIcons();</script>
</body>
</html>
