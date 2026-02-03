<!-- Sekce Portfolio -->
@php use App\Helpers\Utils; @endphp
<section id="portfolio" class="{{ Utils::getBgClass() }} text-white main">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">

            <!-- Levá strana: Nadpis + odkaz -->
            <div class="d-flex align-items-center flex-wrap gap-3 mb-3 w-100">
                <div class="d-flex align-items-center gap-3 flex-grow-1 flex-wrap">
                    <h2 class="section-title mb-0 me-3">Portfolio</h2>

                    <a href="#" class="text-white d-flex align-items-center fs-3" data-bs-toggle="modal"
                        data-bs-target="#portfolioBadgeInfoModal">
                        <i data-bs-tooltip="tooltip" data-bs-placement="top" title="Info - Význam štítků u projektů"
                            class="bi bi-question"></i>
                    </a>

                    <a href="#" class="text-white d-flex align-items-center fs-6" data-bs-toggle="modal"
                        data-bs-target="#techFilterModal">
                        <i data-bs-tooltip="tooltip" data-bs-placement="top" title="Filtrovat technologie"
                            class="bi bi-funnel-fill"></i>
                    </a>

                    <div id="filter-summary" class="d-flex align-items-center flex-wrap gap-2" style="display: none;">
                        <span><strong>Filtry:</strong> <span id="active-filters"></span></span>
                    </div>
                </div>
                <a href="add.php" class="btn btn-themed bg-dark d-flex align-items-center">
                    <i class="bi bi-plus-lg me-2"></i>
                    Přidat projekt
                </a>
                <div id="results-count" class="d-flex align-items-center ms-auto">
                    <strong>Výsledků:</strong> <span id="project-count" class="ms-1 me-1"> {{ $totalProjects }}</span>
                </div>
            </div>

        </div>

        <!-- Modal pro význam štítků -->
        <div class="modal fade" id="portfolioBadgeInfoModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header border-0">
                        <h5 class="modal-title">Význam štítků</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table text-light">
                            <thead>
                                <tr>
                                    <th>Štítek</th>
                                    <th>Popis</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($badges as $badge)
                                    <tr>
                                        <td>
                                            <span
                                                class="badge fw-bold bg-{{ $badge->status_background_color }} text-{{ $badge->status_text_color }}">
                                                {{ $badge->status_label }}
                                            </span>
                                        </td>
                                        <td>{{ $badge->status_description }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal pro filtr -->
        <div class="modal fade" id="techFilterModal" tabindex="-1" aria-labelledby="techFilterModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h5 class="modal-title" id="techFilterModalLabel">Filtr portfolia</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <form id="tech-filter-form">
                        <div class="modal-body">
                            <div class="filter-legend">
                                Filtr podporuje tři stavy:
                                <span class="legend-item checked">Vybráno</span>
                                <span class="legend-item unchecked">Vyloučeno</span>
                                <span class="legend-item neutral">Nezohledněno</span>
                            </div>

                            <div class="filter-grid">
                                @foreach($techGroups as $groupName => $group)
                                    <div>
                                        <div class="d-flex align-items-center mb-2">
                                            <h5>{{ ucwords(str_replace('_', ' ', $groupName)) }}</h5>
                                            @if($groupName === 'programming_languages')
                                                <small class="text-muted-darkmode ms-auto"
                                                    title="Filtrace tagů: všechny vybrané musí být (AND)">AND</small>
                                            @endif
                                        </div>
                                        <div class="checkbox-grid">
                                            @foreach($group as $tech)
                                                <div class="form-check filter-tristate-wrapper" tabindex="0"
                                                    aria-checked="mixed" role="checkbox" data-tech="{{ $tech['tech'] }}"
                                                    data-filter-state="null" id="filter{{ ucfirst($tech['tech']) }}">
                                                    <input type="checkbox" class="form-check-input filter-tristate-checkbox"
                                                        id="filter{{ ucfirst($tech['tech']) }}-checkbox" hidden>
                                                    <span class="custom-checkbox"></span>
                                                    <label for="filter{{ ucfirst($tech['tech']) }}-checkbox"
                                                        title="{!! nl2br(e($tech['title'])) !!}">
                                                        {!! nl2br(e($tech['label'])) !!}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Badges (stav projektu) -->
                                <div>
                                    <div class="d-flex align-items-center mb-2">
                                        <h5>Project state</h5>
                                        <small class="text-muted-darkmode ms-auto"
                                            title="Filtrace štítků: stačí jedna vybraná (OR)">OR</small>
                                    </div>
                                    <div class="checkbox-grid">
                                        @foreach($badges as $badge)
                                            <div class="form-check filter-tristate-wrapper" tabindex="0"
                                                aria-checked="mixed" role="checkbox"
                                                data-version="{!! nl2br(e($badge->status_label)) !!}" data-filter-state="null"
                                                id="filter{!! $badge->id !!}">
                                                <input type="checkbox" class="form-check-input filter-tristate-checkbox"
                                                    id="filter{!! $badge->id !!}-checkbox" hidden>
                                                <span class="custom-checkbox"></span>
                                                <label for="filter{!! $badge->id !!}-checkbox"
                                                    title="{!! nl2br(e($badge->status_description)) !!}">
                                                    <span
                                                        class="badge fw-bold bg-{{ $badge->status_background_color }} text-{{ $badge->status_text_color }} mb-1">
                                                        {!! nl2br(e($badge->status_label)) !!}
                                                    </span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>


                    <div class="modal-footer">
                        <button id="reset-filter" type="button" class="btn btn-warning me-auto">Reset</button>

                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Zavřít</button>
                        <button id="apply-filter" type="button" class="btn btn-success">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <span id="no-results" class="text-light fw-bold fs-5 text-center mt-5 mb-5" style="display: none;">Žádný
                záznam nebyl nalezen.</span>
        </div>

        <div class="row g-3">
            @foreach ($projects as $project)

                <a href="{!! route('detail', ['id' => $project->id]) !!}"
                    class="project col-lg-3 col-md-4 col-sm-6 col-12 d-flex" data-tech="{{ $project->dataTech }}"
                    data-version="{{ $project->dataVersion }}">
                    <div class="card bg-dark text-light flex-fill d-flex flex-column position-relative">

                        @if (session('role') === 'admin')
                            <div class="position-absolute top-0 start-0 d-flex m-2">
                                <span class="admin-btn-ico pin-btn" title="Připnout"><i class="bi bi-pin-angle"></i></span>
                            </div>
                            <div class="position-absolute top-0 end-0 m-2 d-flex gap-1">
                                <span class="admin-btn-ico edit-btn" title="Upravit"><i class="bi bi-pencil"></i></span>
                                <span class="admin-btn-ico delete-btn" title="Smazat"><i class="bi bi-x-lg"></i></span>
                            </div>
                        @endif

                        <div class="ratio ratio-16x9">
                            <img src="{!! nl2br(e($project->thumbnailUrl)) !!}" alt="{!! nl2br(e($project->title)) !!}"
                                class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover">
                        </div>

                        <div class="card-body flex-column d-flex">
                            <h5 class="card-title">{!! nl2br(e($project->title)) !!}</h5>
                            <p class="card-text flex-grow-1">{!! nl2br(e($project->short_description)) !!}</p>
                            <div class="justify-content-between align-items-center mt-auto flex-wrap d-flex">
                                <div class="flex-wrap w-100 d-flex">
                                    @foreach ($project->badgeKeys as $key)
                                        @if(isset($badges[$key]) && $badges[$key]->status_visible === "visible")
                                            <span
                                                class="badge fw-bold bg-{{ $badges[$key]->status_background_color }} text-{{ $badges[$key]->status_text_color }} mt-1 me-1"
                                                title="{!! nl2br(e($badges[$key]->status_description)) !!}">
                                                {!! nl2br(e($badges[$key]->status_label)) !!}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                                <span class="project-link mt-2 text-nowrap ms-auto">[Zobrazit více]</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach

            @if (session('role') === 'admin')
                <a href="" class="project col-lg-3 col-md-4 col-sm-6 col-12 d-flex">
                    <div class="card card-body add-card text-light flex-fill">
                        <div class="add-card-content">
                            <i class="bi bi-plus-lg pt-3"></i>
                            <span class="bold fs-5 pb-3">Přidat projekt</span>
                        </div>
                    </div>
                </a>
            @endif
        </div>

    </div>

    <script src="js/portfolio-filter.js"></script>

</section>