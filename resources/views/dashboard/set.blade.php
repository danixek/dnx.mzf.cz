{{-- 'settings' --}}
<div style="position: absolute; z-index: 5; top: 20px; right: 20px; display: flex; align-items: center">
    @auth
        <img src="{{ $user->avatar_url ?? '/dashboard/img/default-avatar.png' }}" width="40" style="border-radius:50%">
        <strong style="margin-left: 12px">{{ $user->username }}</strong>
    @else
        <span class="href-btn" style="margin-left: 12px" data-bs-toggle="modal" data-bs-target="#loginRegisterModal">
            Přihlásit se
        </span>
    @endauth
</div>

<div class="background-overlay-color"></div>
<style>
    .background-overlay-color {
        background: rgba(0, 0, 0, 0.40) !important;
        top: 0px;
        left: 0px;
        right: 0px;
        bottom: 0px;
        position: fixed;
        z-index: 1;
    }
</style>

<div style="position: absolute; z-index: 5; top: 150px; margin: 0 100px">

    <h2>Profil</h2>

    @guest
        <div class="d-block py-3 row gy-1">
            <span class="href-btn" data-bs-toggle="modal" data-bs-target="#loginRegisterModal">
                Přihlásit se
            </span>
            <p>Pro úpravu nastavení se prosím <span class="href-btn" data-bs-toggle="modal"
                    data-bs-target="#loginRegisterModal">
                    přihlaš</span>.</p>
            <p>Pokud máš propojený účet s Google účtem, můžeš se přes něj i <a href="{{ route('google.login') }}"
                    class="href-btn">
                    přihlásit</a>.</p>
        </div>
    @endguest

    @auth
        <div style="display: flex; align-items: center;">
            <span>
                Přihlášen jako <strong>{{ auth()->user()->username }}</strong>
            </span>
            <div style="margin-left: auto; display: flex; gap: 0.5rem;">
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="href-btn">Odhlásit se</button>
                </form>
                @if (!auth()->user()->google_id)
                    <a href="{{ route('google.login') }}" class="href-btn">Propojit účet Google</a>
                @endif
            </div>
        </div>

        <form method="post" action="{{ route('dashboard.save-settings') }}">
            @csrf

            <h2>Tapety</h2>
            <p class="form-description">Vyberte pozadí domovské obrazovky.</p>
            <div class="wallpaper-selection" name="wallpaper_position">
                @foreach ($wallpapers as $filename)
                    <div class="wallpaper-thumb">
                        <input type="radio" id="wp-{{ $filename }}" name="wallpaper" value="{{ $filename }}" {{ $preferences->wallpaper === $filename ? 'checked' : '' }} hidden>
                        <label for="wp-{{ $filename }}">
                            <img src="{{ asset('assets/dashboard/img/' . $filename) }}" width="100"
                                style="cursor:pointer; border-radius:8px;">
                        </label>
                    </div>
                @endforeach
            </div>
            <h2>Pozice tapety</h2>
            <p class="form-description">
                Určuje, která část obrázku bude vycentrovaná. Např. „Na střed“ zobrazí střed tapety.
            </p>
            <input type="hidden" name="dashboard_id" value="{{ $settings->id ?? '' }}">
            <select id="wallpaper-position" name="wallpaper_position" required>
                @foreach ($wallpaperPositionsList as $value => $label)
                    <option value="{{ $value }}" {{ $preferences->wallpaperPosition === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>

            <h2>Vyhledávač</h2>
            <p class="form-description">
                Určuje, který vyhledávač se použije při zadání dotazu do vyhledávacího pole.
            </p>
            <select id="search-engine" name="search_engine" required>
                @foreach ($engines as $value => $label)
                    <option value="{{ $value }}" {{ $preferences->searchEngine === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>

            <h2>Záložky</h2>
            <p class="form-description">
                Záložky slouží k rychlému přístupu k oblíbeným webům. Zobrazují se pod vyhledávačem na hlavní stránce.
            </p>

            <div id="bookmarks-container">
                @forelse ($bookmarks as $bookmark)
                    <div class="bookmark-item">
                        <input type="hidden" name="bookmark[{{ $bookmark->id }}]" value="{{ $bookmark->id }}">
                        <input type="text" name="bookmark[{{ $bookmark->id }}]" value="{{ $bookmark->title }}" required class="bookmark-title">
                        <input type="url" name="bookmark[{{ $bookmark->id }}]" value="{{ $bookmark->url }}" required class="bookmark-url">
                        <select name="bookmark[{{ $bookmark->id }}]" class="bookmark-category" id="bookmark-template">
                            <option value="">Vše</option>
                            @foreach(['sluzby' => 'Služby', 'zpravy' => 'Zprávy', 'technologie' => 'Tech', 'geek' => 'Geek', 'uceni' => 'Učení'] as $catValue => $catLabel)
                                <option value="{{ $catValue }}" {{ $bookmark->category === $catValue ? 'selected' : '' }}>
                                    {{ $catLabel }}
                                </option>
                            @endforeach
                        </select>
                        <button type="button" class="remove-bookmark delete-btn">Smazat</button>
                    </div>
                @empty
                    <p>Žádné záložky</p>
                @endforelse
            </div>
            <button type="button" id="add-bookmark" class="add-btn">Přidat záložku</button>

            <h2>RSS (Zprávy)</h2>
            <p class="form-description">
                Seznam zdrojů zpráv, ze kterých se načítají články na hlavní stránku.
            </p>
            <div id="rss-container">
                @forelse ($feeds as $feed)
                    <div class="rss-item">
                        <input type="hidden" name="feed[{{ $feed->id }}]" value="{{ $feed->id }}">
                        <input type="url" name="feed[{{ $feed->feed_url }}]" placeholder="RSS URL" value="{{ e($feed->feed_url) }}"
                           class="rss-url" required >
                        <button type="button" class="remove-rss delete-btn">Smazat</button>
                    </div>
                @empty
                    <p>Žádné RSS zdroje</p>
                @endforelse

            </div>
            <button type="button" id="add-rss" class="add-btn">Přidat RSS</button>

            <div style="margin-top: 50px; margin-bottom: 150px">
                <button type="submit" class="save-btn">Uložit</button>
                <a href="?dash" class="href-btn" style="padding-left: 10px">Zpět na dashboard</a>
            </div>
        </form>

    @endauth