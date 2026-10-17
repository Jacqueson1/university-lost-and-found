<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Lost & Found')</title>
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="user-body">

    <!-- ===== NAVBAR ===== -->
    <header class="navbar">

        <a href="{{ route('items.index') }}" class="navbar__brand">
            <i data-lucide="search-check"></i> Lost &amp; Found
        </a>

        <nav class="navbar__links">
            @auth
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn--ghost"><i data-lucide="shield-check"></i>
                        Admin</a>

                @endif

                <a href="{{ route('claims.index') }}" class="btn btn--ghost"><i data-lucide="clipboard-list"></i> My
                    Claims</a>

                <a href="{{ route('items.create') }}" class="btn btn--primary">
                    <i data-lucide="plus-circle"></i> Report Item
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn--ghost"><i data-lucide="log-out"></i> Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn--ghost"><i data-lucide="log-in"></i> Login</a>

                <a href="{{ route('register') }}" class="btn btn--primary">Sign up</a>

            @endauth
        </nav>
    </header>

    <!-- ===== PAGE CONTENT ===== -->
    <main class="container">
        @if (session('success'))
            <div class="alert"><i data-lucide="check-circle"></i> {{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

    <footer class="footer">Found it, Report it, Reunite with it.</footer>

    <script>
        lucide.createIcons(); // turns <i data-lucide="..."> into icons
    </script>
</body>

</html>
