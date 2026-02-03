{{-- 'dashboard' - výchozí --}}
<div class="background-overlay"></div>

<main>
    <?php
$engine = $_SESSION['search_engine'] ?? 'google';

$searchUrls = [
    'google' => 'https://www.google.com/search?q=',
    'duckduckgo' => 'https://duckduckgo.com/?q=',
    'bing' => 'https://www.bing.com/search?q=',
    'seznam' => 'https://search.seznam.cz/?q=',
    'brave' => 'https://search.brave.com/search?q='
];

$searchBase = $searchUrls[$engine] ?? $searchUrls['google'];

            ?>

    <!-- Vyhledávač -->
    <form id="searchForm" method="get" target="_parent" action="<?= htmlspecialchars($searchBase) ?>">
        <div class="search-section" style="display: flex; flex-direction: column; align-items: center; width: 100%;">
            <div class="search-logo"
                style="display: flex; justify-content: center; opacity: 0.5; align-items: center; width: 100%; margin-bottom: 4em">
                <img src="{{ asset('assets/logo/dnx-logo_mini_120px.png') }}" alt="Logo">
            </div>
            <div class="search-wrapper" style="width: 100%; display: flex; justify-content: center;">
                <ul class="autocomplete-list"></ul>
                <input type="text" id="search-input" name="q" placeholder="Hledat na webu..." autocomplete="off"
                    style="width: 100%; max-width: 570px;">
            </div>
        </div>
    </form>


    <!-- Filtry -->
    <div class="filter-bar">
        <button class="filter-btn active" data-filter="all">Vše</button>
        <button class="filter-btn" data-filter="sluzby">Služby</button>
        <button class="filter-btn" data-filter="zpravy">Zprávy</button>
        <button class="filter-btn" data-filter="technologie">Technologie</button>
        <button class="filter-btn" data-filter="geek">Geek</button>
        <button class="filter-btn" data-filter="uceni">Učení</button>
    </div>

    <!-- Záložky -->
    <section class="bookmarks">

        @if (!empty(auth()->user()))
            @foreach ($bookmarks as $bookmark)

                <a href="<?= $bookmark->url ?>" class="bookmark" data-category="<?= $bookmark->category ?>"><?= $bookmark->title ?></a>
            @endforeach
        @else
            <a href="https://youtube.com" class="bookmark" data-category="sluzby">YouTube</a>
            <a href="https://facebook.com" class="bookmark" data-category="sluzby">Facebook</a>
            <a href="https://irozhlas.cz" class="bookmark" data-category="zpravy">iRozhlas</a>
            <a href="https://www.respekt.cz" class="bookmark" data-category="zpravy">RESPEKT</a>
            <a href="https://www.reflex.cz" class="bookmark" data-category="zpravy">Reflex</a>
            <a href="https://www.disneyplus.com/cs-cz/home" class="bookmark" data-category="geek">Disney+</a>
            <p class="w-100 mx-auto d-block">Pro vlastní nastavení se musíte přihlásit.</p>
        @endif

    </section>