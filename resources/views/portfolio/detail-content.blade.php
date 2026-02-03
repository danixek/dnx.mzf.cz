@php use App\Helpers\Utils; @endphp

<!-- Sekce Detail - detail portfolia -->
<section id="detail" class="{{  Utils::getBgClass() }} py-5 text-white">
    <div class="container">
        <div class="row align-items-start">
            <!-- Galerie vlevo -->
            @include('portfolio.detail-gallery', ['gallery' => $project->gallery, 'mainImage' => $mainImage])

            <!-- Informace vpravo -->
            <div class="col-md-8">
                <!-- Nadpis + status (version) badge + verze -->
                <div class="d-flex flex-wrap flex-lg-nowrap align-items-center mb-2">
                    <h2 class="project-title mb-0 me-3">
                        {!! nl2br(e($project->title)) !!}
                    </h2>
                    <!-- Status badge, aneb verze projektu -->
                    @foreach ($project->projectBadges as $badgeId)
                        @if (isset($badges[$badgeId]) && $badges[$badgeId]->status_visible === 'visible')
                            <span
                                class="badge fw-bold bg-{{ nl2br(e($badges[$badgeId]->status_background_color)) }} text-{{ $badges[$badgeId]->status_text_color }} me-2"
                                data-bs-tooltip="tooltip" data-bs-placement="top" style="font-weight: bold"
                                title="{{ $badges[$badgeId]->status_description }}">
                                {!! nl2br(e($badges[$badgeId]->status_label)) !!}
                            </span>
                        @endif
                    @endforeach

                    <!-- Verze jako badge -->
                    @if (!empty($project->version))
                        <span class="badge text-white ms-2" data-bs-tooltip="tooltip" data-bs-placement="top"
                            title="Verze projektu: v{!! nl2br(e($project->version)) !!}">
                            v{!! nl2br(e($project->version)) !!}
                        </span>
                    @endif

                </div>

                <!-- Popisek projektu -->
                <p class="project-description mt-3">{!! nl2br(e($project->description)) !!}</p>


                <!-- Poznámka "pod čarou" k popisku -->
                @if (!empty($project->note))
                    <p class="text-warning fw-bold mt-4">
                        {!! nl2br(e($project->note)) !!}
                    </p>
                @endif

                <!-- Tagy (použité technologie) + datum dokončení dané verze -->
                @if (!empty($project->tags) || !empty($project->completion_date))

                    <div class="mb-3 d-flex flex-wrap gap-2 mt-4 mb-4">
                        @php $czechCompletionDate = Utils::CzechDate($project->completion_date); @endphp
                        @if(!empty($czechCompletionDate))
                            <span class="badge" data-bs-tooltip="tooltip" data-bs-placement="top"
                                title="Datum poslední změny: {!! nl2br(e($czechCompletionDate)) !!}">
                                <i class="bi bi-calendar-event me-1"></i>
                                {!! nl2br(e($czechCompletionDate)) !!}
                            </span>
                        @endif

                        @if (!empty($project->tags))
                            @foreach (explode(',', $project->tags) as $tag)
                                <span class="badge fw-bold bg-secondary">{!! nl2br(e(trim($tag))) !!}</span>
                            @endforeach
                        @endif

                    </div>
                @endif

                <!-- Odkazy ke stažení - začátek -->
                <div class="d-flex flex-wrap align-items-center mt-4">
                    @include('portfolio.project-links', ['links' => $project->links])
                    <!-- Collapse tlačítko na odkrytí changelogu -->
                    <button class="btn btn-themed ms-auto" type="button" data-bs-tooltip="tooltip"
                        data-bs-placement="top" title="changelog" data-bs-toggle="collapse"
                        data-bs-target="#changelogCollapse" aria-expanded="false" aria-controls="changelogCollapse">
                        <i class="bi bi-journal-text"></i>
                    </button>
                </div>
                <!-- Odkazy ke stažení - konec -->

                <!-- Collapse obsah - Changelog -->
                <div class="collapse mt-4" id="changelogCollapse">
                    <div class="card card-body" style="background-color: rgba(30, 30, 30, 0.5)">
                        <h5>Changelog</h5>
                        @if (!empty($project->changelog))
                            <ul class="mb-0" style="list-style-type: disc; padding-left: 1.15rem;">
                                @foreach ($project->changelog as $item)
                                    <li>
                                        <div class="d-flex justify-content-between">
                                            <strong>Verze {!! nl2br(e($item->version)) !!}</strong>
                                            @if (!empty($item->date))
                                                <small
                                                    class="text-muted-darkmode">{!! nl2br(e(Utils::CzechDate($item->date))) !!}</small>
                                            @endif
                                        </div>

                                        @if (!empty($item->notes))
                                            <ul class="notes-list">
                                                @foreach (explode('\\n', $item->notes) as $line)
                                                    @if(trim($line) !== '')
                                                        <li><small>{{ $line }}</small></li>
                                                    @endif
                                                @endforeach

                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted-darkmode mb-0">Zatím žádné změny.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>