<!DOCTYPE html>
<html lang="cs">

@include('portfolio.header')

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-J4QB2029QQ"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config', 'G-J4QB2029QQ');
</script>

<body id="page-wrapper">
    <header>
        @include('portfolio.navbar')
        {{-- Sekce domů - speciální verze bez citátů --}}
        @yield('hero')
    </header>

    <main>
        {{-- Knihovna --}}
        @yield('content')
    </main>

    <footer>
        @include('portfolio.modals')
        @include('detail.quotes')
        @include('portfolio.contacts')

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/portfolio/js/quotes.js') }}"></script>
    @if(request()->is('detail*'))
        <script src="{{ asset('assets/portfolio/js/detail-gallery.js') }}"></script>
    @endif
    <script src="{{ asset('assets/portfolio/js/bs-tooltip.js') }}"></script>

</body>

</html>