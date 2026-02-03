<!DOCTYPE html>
<html lang="cs" class="theme-dark">

<head>
    <meta charset="UTF-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="{{ asset('assets/logo/dnx-logo_mini.ico') }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('assets/dashboard/index.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/endora-ads.css') }}">
</head>

<body>
    <div id="background-overlay"></div>    
    <a class="logo-wrapper" href="?">
        <img src="{{ asset('assets/logo/dnx-logo_mini_60px.png') }}" alt="Logo">
        <span class="logo-text">
            <span class="visually-hidden">d</span>
            <span class="logo_text-show" id="logo-text">nx</span>
        </span>
    </a>
    @include('portfolio.modals')

    @php
        use App\Helpers\Logger;
        $user = auth()->user();
    @endphp

    <style>
        #background-overlay {
            background: url('{{ asset("assets/dashboard/img/" . $preferences->wallpaper) }}') no-repeat
                {{ $preferences->wallpaperPosition }}
                /cover;
        }
    </style>

    @if (isset($_GET['rss']))
        {{-- 'rss' --}}
        @include('dashboard.rss')
    @elseif (isset($_GET['set']))
        {{-- 'settings' --}}
        @include('dashboard.set')
    @else
        {{-- 'dashboard' - default --}}
        @include('dashboard.dash')
    @endif
    </main>

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

</body>

{{-- 
<script src="{{ mix('js/dashboard/main.js') }}"></script>
<link rel="stylesheet" href="{{ mix('css/app.css') }}">
 --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</html>