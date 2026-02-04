{{-- LIST --}}
@if (!isset($slug))

<section id="blog" class="{{ $bgClass }} py-5 text-white">
    <div class="container">
        <div class="row g-3">
            <h2 class="section-title">Články</h2>

            @forelse($posts as $post)
                <a href="{{ route('blog', ['post' => $post['slug']]) }}"
                   class="col-lg-3 col-md-4 col-sm-6 col-12 d-flex text-decoration-none">

                    <div class="card bg-dark text-light flex-fill">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset($post['image']) }}"
                                 class="w-100 h-100 object-fit-cover">
                        </div>
                        <div class="card-body">
                            <h5>{{ $post['title'] }}</h5>
                            <p>{{ $post['excerpt'] }}…</p>
                        </div>
                    </div>
                </a>
            @empty
                <p>Žádné články nebyly publikovány.</p>
            @endforelse

        </div>
    </div>
</section>

{{-- DETAIL --}}
@else

<section id="blog" class="{{ $bgClass }} text-white py-5">
    <div class="container">

        <h1>{{ $title }}</h1>

        <div class="ratio ratio-16x9 my-4">
            <img src="{{ asset($image) }}"
                 class="rounded-3 object-fit-cover w-100 h-100">
        </div>

        <div class="markdown-body">
            {!! $content !!}
        </div>

        <p class="mt-3">
            <a href="{{ route('blog') }}">← Zpět na seznam článků</a>
        </p>

        <p style='font-size: 90%; padding-bottom: 5px; color: #ccc;'>
            @if($date) 🗓️ {{ $date }} · @endif
            <span class="badge bg-secondary">.markdown powered</span>
            @if(!empty($tags)) · 🏷️ {{ implode(', ', $tags) }} @endif
        </p>

    </div>
</section>

@endif