{{-- RSS --}}
@if (!$user)
    <div class="rss-feed text-center" style="margin-top: 150px">
        <p>Pro zobrazení RSS feedu se musíte přihlásit.</p>
    </div>
@else

    <img src="/logo/dnx-logo_mini_120px.png"
         style="opacity: .6; position: absolute; top: 200px; left: 50%; transform: translateX(-50%)"
         alt="Logo">

    <div class="rss-feed" style="margin: 0 20%; margin-top: 450px">
        @forelse ($feedItems as $article)
            <div class="article mb-3 d-flex flex-wrap align-items-center gap-3">

                @if ($article['image'])
                    <img src="{{ $article['image'] }}" class="article-image" alt="náhled">
                @endif

                <div>
                    <a href="{{ $article['link'] }}" target="_blank" class="article-title">
                        {{ $article['title'] }}
                    </a>

                    <div class="text-muted small">
                        {{ $article['pubDate']
                            ? \Carbon\Carbon::createFromTimestamp($article['pubDate'])->format('j. n. Y')
                            : '' }}
                    </div>
                </div>

            </div>
        @empty
            <p>Žádné články k zobrazení.</p>
        @endforelse
    </div>
@endif
