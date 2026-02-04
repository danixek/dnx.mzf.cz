<!DOCTYPE html>
<html lang="cs">
@include('detail.blog-header')

<body id="page-wrapper">
    <header>
        @include('portfolio.navbar')
        @yield('hero')
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        @include('portfolio.modals')
        @include('detail.quotes')
        @include('portfolio.contacts')
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/portfolio/js/quotes.js') }}"></script>
    <script src="{{ asset('assets/portfolio/js/bs-tooltip.js') }}"></script>

    @stack('scripts')
</body>

</html>