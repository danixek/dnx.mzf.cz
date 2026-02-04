<a href="{{ $url }}" class="project col-lg-3 col-md-4 col-sm-6 col-12 d-flex" data-tags="{{ $tags }}">

    <div class="card bg-dark text-light flex-fill" style="background-color:rgba(0,0,0,.22)!important">

        <div class="ratio ratio-16x9">
            <img src="{{ $thumbnail }}" alt="{{ $title }}" aria-label="{{ $title }}"
                class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover">
        </div>

        <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ $title }}</h5>

            <p class="card-text flex-grow-1" style="display:none">
                {{ $shortDescription }}
            </p>

            <div class="mt-auto d-flex justify-content-end">
                <span class="project-link text-nowrap" style="display:none">
                    [Zobrazit více]
                </span>
            </div>
        </div>

    </div>
</a>