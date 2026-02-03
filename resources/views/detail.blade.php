<!DOCTYPE html>
<html lang="cs">

@include('portfolio.header')
@php
    use App\Helpers\Utils;
    use App\Helpers\Logger;
@endphp

<body>
    <header>

        {{-- Navigační menu --}}
        @include('portfolio.navbar')

        <!-- Sekce domů - speciální verze bez citátů -->
        <section id="home" class="<?= Utils::getBgClass('bg-light-gray') ?> text-center text-white pt-4">
            <div class="container mt-5 pt-4">
                <h1 class="display-4">Hello, I'm a Programmer</h1>
                <p class="lead pt-4">Vytvářím řešení pomocí C#, ASP.NET a WPF;<br>
                    od backendu po rozhraní</p>
            </div>
        </section>
    </header>
    @php
        $mainImage = $project->gallery[0] ?? 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKAAAAA5CAYAAABxNnTaAAAAFElEQVR4nO3BMQEAAAgDoJvcf+FAAFY7gW8FAAAAAAAAAAAAAPA3A9MNAAEKCcAAAAASUVORK5CYII=';
    @endphp
    <main>
        <!-- Sekce Detail - detail portfolia -->
        @include('portfolio.detail-content', ['project' => $project, 'mainImage' => $mainImage])

    </main>
    <footer>
        {{-- Citáty --}}
        @include('portfolio.quotes')

        {{-- Kontakt --}}
        @include('portfolio.contacts')
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/portfolio/js/quotes.js') }}"></script>
    <script src="{{ asset('assets/portfolio/js/bs-tooltip.js') }}"></script>
    <!-- JS skripty ke galerii -->
    <script src="{{ asset('assets/portfolio/js/detail-gallery.js') }}"></script>


</body>

</html>