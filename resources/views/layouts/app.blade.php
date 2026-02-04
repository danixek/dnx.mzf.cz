<!DOCTYPE html>
<html lang="cs">

@include('portfolio.header')

<!-- Google tag -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-JLWMMCFJX5"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config', 'G-JLWMMCFJX5');
</script>

<body id="page-wrapper">
    <header>
        @include('portfolio.navbar')
        {{-- Sekce domů - nadpis a citáty --}}
        @yield('hero')
    </header>

    <main>
        {{-- Portfolio --}}
        @yield('content')
    </main>

    <footer>
        @include('portfolio.blog')
        @include('portfolio.contacts')
        @include('portfolio.modals')
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/portfolio/js/quotes.js') }}"></script>
    <script src="{{ asset('assets/portfolio/js/bs-tooltip.js') }}"></script>

    @stack('scripts')

</body>

</html>