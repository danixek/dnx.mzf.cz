<!DOCTYPE html>
<html lang="cs">

@php
    use App\Helpers\Utils;
@endphp

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
        <!-- Sekce domů - speciální verze bez citátů -->
        <section id="home" class="{{ Utils::getBgClass('bg-light-gray') }} text-center text-white pt-4">
            <div class="container mt-5 pt-4">
                <h1 class="display-2"><span style="position: relative; bottom: 4px">[</span> <span
                        style="font-size: 80%">d</span><span style="position: relative; bottom: 4px">]</span></h1>
                <p class="lead pt-4">O světě, kódu a myšlení.</p>
            </div>
        </section>
    </header>

    <main>
        <section id="library" class="{{ Utils::getBgClass() }} text-white">
            <div class="container">

                <h2 class="section-title me-3 mb-3">Knihovna – Moje doporučení</h2>

                <span class="alert d-flex mb-0" style="border-left:3px solid rgb(155,155,155);border-radius:0">
                    Tato podstránka je stále ve vývoji.
                </span>

                <p class="mt-3">
                    Tady jsou k nalezení věci, které mě nějak zasáhly, zaujaly, inspirovaly
                    nebo prostě jen bavily.
                </p>

                <div class="text-center">
                    <div class="btn-group">
                        <a href="?l=0" class="btn btn-themed"><i class="bi bi-lightbulb me-2"></i>Přednášky</a>
                        <a href="?l=1" class="btn btn-themed"><i class="bi bi-collection-play me-2"></i>Filmy+</a>
                        <a href="?l=2" class="btn btn-themed"><i class="bi bi-controller me-2"></i>Hry</a>
                    </div>
                </div>

                <div class="my-4">

                    @if (empty($items))
                        <p>⚠️ Žádná data.</p>
                    @endif

                    <h2>{{ $category }}</h2>

                    <div class="row g-3 mt-2">
                        @foreach ($items as $item)

                            @include('portfolio.library_card', $item)

                        @endforeach
                    </div>
                </div>

                <a href="/" class="btn btn-themed mt-3">Zpět na domovskou stránku</a>

            </div>
        </section>
    </main>

    <footer>
        @include('portfolio.quotes')

        @include('portfolio.contacts')
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/portfolio/js/quotes.js') }}"></script>
    <script src="{{ asset('assets/portfolio/js/bs-tooltip.js') }}"></script>

</body>

</html>