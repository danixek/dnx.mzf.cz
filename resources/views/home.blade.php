<!DOCTYPE html>
<html lang="cs">
{{-- Utilita v PHP na přepínání barev frontendu - CSS přepínač --}}
<?php
use App\Helpers\Utils;
$bgClass = Utils::getBgClass();
use App\Helpers\Logger; ?>

@include('portfolio.header')

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-JLWMMCFJX5"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());

    gtag('config', 'G-JLWMMCFJX5');
</script>

<body id="page-wrapper">
    <header>

        {{-- Navigační menu --}}
        @include('portfolio.navbar')

        {{-- Domů - nadpis, podnadpis a citáty --}}
        @include('portfolio.home')
    </header>
    <main>
        {{-- O mně --}}
        @include('portfolio.about')

        {{-- Portfolio --}}
        @include('portfolio.portfolio')

        {{-- Blog --}}
        @include('portfolio.blog')
    </main>

    <footer>
        {{-- Kontakt --}}
        @include('portfolio.contacts')
        @include('portfolio.modals')
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/portfolio/js/quotes.js') }}"></script>
    <script src="{{ asset('assets/portfolio/js/bs-tooltip.js') }}"></script>

    {{-- 
    <div id="app"></div>
    @vite('resources/js/DEVportfolio/main.js')
    --}}

</body>

</html>