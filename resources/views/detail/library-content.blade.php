<section id="library" class="{{ $bgClass }} text-white">
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

                    @include('detail.library_card', $item)

                @endforeach
            </div>
        </div>

        <a href="/" class="btn btn-themed mt-3">Zpět na domovskou stránku</a>

    </div>
</section>