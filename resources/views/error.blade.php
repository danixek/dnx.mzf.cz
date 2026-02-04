<!DOCTYPE html>
<html lang="cs">
<?php
use App\Helpers\Logger; ?>

@include('portfolio.header') 

<body>
    <header>

        {{-- Navigační menu --}}
        @include('portfolio.navbar')

        {{-- Sekce domů - speciální verze bez citátů --}} 
        <section id="home" class="{{ $bgClass }} text-center text-white pt-4">
            <div class="container mt-5 pt-4">
                <h1 class="display-1">[ <span class="d-inline-block" style="position: relative; top: 10px">d</span>]</h1>
                <p class="lead pt-3">Chcete se vrátit na domovskou stránku?</p>
                <a href="{{ url('/') }}" class="lead d-inline-block">[Klik]</a>
            </div>
        </section>
    </header>
    <main>
        {{-- Sekce Blog --}}
        <section id="error" class="{{ $bgClass }} py-5 text-white">
            <div class="container">
                <div class="row text-center">
                    <h2 class="display-5 pt-4">Error {{ $code }}</h2>
                    <p class="lead pt-2">{{ $error['message'] }}</p>
                </div>
            </div>
        </section>
    </main>
    <footer>
        {{--  Citáty  --}} 
        @include('portfolio.quotes')

        {{--  Kontakt  --}}
        @include('portfolio.contacts')
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/quotes.js"></script>
    <script src="js/bs-tooltip.js"></script>


</body>

</html>