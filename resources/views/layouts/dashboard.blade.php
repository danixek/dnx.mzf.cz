<!DOCTYPE html>
<html lang="cs" class="theme-dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>@yield('title', 'Dashboard')</title>

    {{-- CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="{{ asset('assets/logo/dnx-logo_mini.ico') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('assets/dashboard/index.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/endora-ads.css') }}">

    @stack('head')
</head>

<body>

    <div id="background-overlay"></div>

    {{-- Logo --}}
    <a class="logo-wrapper" href="{{ route('dashboard') }}">
        <img src="{{ asset('assets/logo/dnx-logo_mini_60px.png') }}" alt="Logo">
        <span class="logo-text">
            <span class="visually-hidden">d</span>
            <span class="logo_text-show" id="logo-text">nx</span>
        </span>
    </a>

    {{-- Modály --}}
    @include('portfolio.modals')

    {{-- Background (wallpaper) --}}
    @isset($preferences)
        <style>
            #background-overlay {
                background:
                    url('{{ asset("assets/dashboard/img/" . $preferences->wallpaper) }}') no-repeat
                    {{ $preferences->wallpaperPosition }}
                    / cover;
            }
        </style>
    @endisset

    {{-- HLAVNÍ OBSAH --}}
    <main>
        @yield('content')
    </main>

    {{-- Spodní navigace --}}
    <nav class="bottom-navbar">
        <a href="?dash" class="nav-icon {{ $tab === 'dash' ? 'active' : '' }}">🏠</a>
        <a href="?rss" class="nav-icon {{ $tab === 'rss' ? 'active' : '' }}">📡</a>
        <a href="?set" class="nav-icon {{ $tab === 'set' ? 'active' : '' }}">⚙️</a>
    </nav>
    <!-- Javascript pro dash -->
    @if(($tab ?? null) === 'dash' || !isset($tab))
        <script src="{{ asset('assets/dashboard/js/filter-bookmark.js') }}"></script>
    @endif

    <!-- Javascript - Obecné -->
    <script src="{{ asset('assets/dashboard/js/scroll-wallpaper.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/navbar-hide.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/logo-animated.js') }}"></script>

    <!-- Javascript pro nastavení -->
    @if(($tab ?? null) === 'set' && auth()->check())
        <script src="{{ asset('assets/dashboard/js/settings-add.js') }}"></script>
        <script src="{{ asset('assets/dashboard/js/settings-wallpaper.js') }}"></script>
    @endif

    @vite(['resources/js/types/app.js', "resources/js/dashboard/{$page['component']}.vue"])
</body>

</html>