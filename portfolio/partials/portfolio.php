<!-- Sekce Portfolio -->
<section id="portfolio" class="<?= getBgClass() ?> text-white main">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <?php
            $data = json_decode(file_get_contents('portfolio/portfolio.json'), true);
            $pinnedIds = $data['pinnedIds'] ?? [];
            $projects = $data['projects'] ?? [];
            $badgesMap = $data['badges'] ?? [];
            ?>

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
                <?php
                $jsonFile = __DIR__ . '/../portfolio.json';

                $projectsArray = [];

                if (file_exists($jsonFile)) {
                    $jsonContent = file_get_contents($jsonFile);
                    $decodedJson = json_decode($jsonContent, true);

                    if (is_array($decodedJson) && isset($decodedJson['projects']) && is_array($decodedJson['projects'])) {
                        $projectsArray = $decodedJson['projects'];
                    }
                }

                $totalProjects = count($projectsArray);
                ?>


                <div id="results-count" class="d-flex align-items-center ms-auto">
                    <strong>Výsledků:</strong> <span id="project-count" class="ms-1 me-1"><?= $totalProjects ?></span>
                </div>
            </div>


            <!-- Pravá strana: Zobrazit více --> <!--
            <a class="btn btn-link p-0 collapse-link" data-bs-toggle="collapse" href="#collapsePortfolio" role="button"
                aria-expanded="false" aria-controls="collapsePortfolio">
                [Zobrazit více]
            </a> -->
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
                                <?php
                                foreach ($badgesMap as $badgeKey => $badge): ?>
                                    <tr>
                                        <td>
                                            <span
                                                class="badge bg-<?= htmlspecialchars($badge['statusBackgroundColor']) ?> text-<?= htmlspecialchars($badge['statusTextColor']) ?>">
                                                <?= htmlspecialchars($badge['statusLabel']) ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($badge['statusDescription']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
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
                                <div>
                                    <div class="d-flex align-items-center mb-2">
                                        <h5>Programovací jazyky</h5>
                                        <small class="text-muted-darkmode ms-auto" data-bs-tooltip="tooltip"
                                            data-bs-placement="top"
                                            title="Filtrace technologií: všechny vybrané musí být (AND)">AND</small>
                                    </div>
                                    <div class="checkbox-grid">
                                        <div class="form-check filter-tristate-wrapper" tabindex="0"
                                            aria-checked="mixed" role="checkbox" data-tech="c#" data-filter-state="null"
                                            id="filterCSharp">
                                            <input type="checkbox" class="form-check-input filter-tristate-checkbox"
                                                id="filterCSharp-checkbox" hidden>
                                            <span class="custom-checkbox"></span>
                                            <label for="filterCSharp-checkbox" data-bs-tooltip="tooltip"
                                                title="C# - programovací jazyk">C#</label>
                                        </div>
                                        <div class="form-check filter-tristate-wrapper" tabindex="0"
                                            aria-checked="mixed" role="checkbox" data-tech="javascript"
                                            data-filter-state="null" id="filterJavaScript">
                                            <input type="checkbox" class="form-check-input filter-tristate-checkbox"
                                                id="filterJavaScript-checkbox" hidden>
                                            <span class="custom-checkbox"></span>
                                            <label for="filterJavaScript-checkbox" data-bs-tooltip="tooltip"
                                                title="Javascript/Typescript - využívá se ve webovém vývoji">JS/TS</label>
                                        </div>
                                        <div class="form-check filter-tristate-wrapper" tabindex="0"
                                            aria-checked="mixed" role="checkbox" data-tech="python"
                                            data-filter-state="null" id="filterPython">
                                            <input type="checkbox" class="form-check-input filter-tristate-checkbox"
                                                id="filterPython-checkbox" hidden>
                                            <span class="custom-checkbox"></span>
                                            <label for="filterPython-checkbox" data-bs-tooltip="tooltip"
                                                title="Prostě python">Python</label>
                                        </div>
                                        <!-- další checkboxy -->
                                    </div>
                                </div>

                                <div>
                                    <div class="d-flex align-items-center mb-2">
                                        <h5>Frameworky a technologie</h5>
                                    </div>
                                    <div class="checkbox-grid">
                                        <div class="form-check filter-tristate-wrapper" tabindex="0"
                                            aria-checked="mixed" role="checkbox" data-tech="asp.net"
                                            data-filter-state="null" id="filterASPNET">
                                            <input type="checkbox" class="form-check-input filter-tristate-checkbox"
                                                id="filterASPNET-checkbox" hidden>
                                            <span class="custom-checkbox"></span>
                                            <label for="filterASPNET-checkbox" data-bs-tooltip="tooltip"
                                                title="C# technologie pro tvorbu (nejen) webových aplikací">ASP.NET</label>
                                        </div>
                                        <div class="form-check filter-tristate-wrapper" tabindex="0"
                                            aria-checked="mixed" role="checkbox" data-tech="wpf"
                                            data-filter-state="null" id="filterWPF">
                                            <input type="checkbox" class="form-check-input filter-tristate-checkbox"
                                                id="filterWPF-checkbox" hidden>
                                            <span class="custom-checkbox"></span>
                                            <label for="filterWPF-checkbox" data-bs-tooltip="tooltip"
                                                title="C# technologie pro tvorbu UI programů">WPF</label>
                                        </div>
                                        <div class="form-check filter-tristate-wrapper" tabindex="0"
                                            aria-checked="mixed" role="checkbox" data-tech="bootstrap"
                                            data-filter-state="null" id="filterBootstrap">
                                            <input type="checkbox" class="form-check-input filter-tristate-checkbox"
                                                id="filterBootstrap-checkbox" hidden>
                                            <span class="custom-checkbox"></span>
                                            <label for="filterBootstrap-checkbox" data-bs-tooltip="tooltip"
                                                title="CSS framework pro rychlou tvorbu moderních a responzivních webů">Bootstrap</label>
                                        </div>
                                    </div>
                                    <div class="checkbox-grid">
                                        <div class="form-check filter-tristate-wrapper" tabindex="0"
                                            aria-checked="mixed" role="checkbox" data-tech="sql"
                                            data-filter-state="null" id="filterSQL">
                                            <input type="checkbox" class="form-check-input filter-tristate-checkbox"
                                                id="filterSQL-checkbox" hidden>
                                            <span class="custom-checkbox"></span>
                                            <label for="filterSQL-checkbox" data-bs-tooltip="tooltip"
                                                title="Do SQL spadá MSSQL a MySQL, a další.">SQL</label>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center mb-2">
                                        <h5>Verze projektu</h5>
                                        <small class="text-muted-darkmode ms-auto" data-bs-tooltip="tooltip"
                                            data-bs-placement="top"
                                            title="Filtrace verzí: stačí jedna vybraná (OR)">OR</small>
                                    </div>
                                    <div class="checkbox-grid">
                                        <?php foreach ($badgesMap as $badgeKey => $badge): ?>
                                            <div class="form-check filter-tristate-wrapper" tabindex="0"
                                                aria-checked="mixed" role="checkbox"
                                                data-version="<?= htmlspecialchars($badgeKey) ?>" data-filter-state="null"
                                                id="filter<?= ucfirst($badgeKey) ?>">

                                                <input type="checkbox" class="form-check-input filter-tristate-checkbox"
                                                    id="filter<?= ucfirst($badgeKey) ?>-checkbox" hidden>
                                                <span class="custom-checkbox"></span>

                                                <label for="filter<?= ucfirst($badgeKey) ?>-checkbox"
                                                    data-bs-tooltip="tooltip"
                                                    title="<?= htmlspecialchars($badge['statusDescription']) ?>">
                                                    <span class="badge bg-<?= htmlspecialchars($badge['statusBackgroundColor']) ?>
                                                    text-<?= htmlspecialchars($badge['statusTextColor']) ?> mb-1">
                                                        <?= htmlspecialchars($badge['statusLabel']) ?>
                                                    </span>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
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
        <?php

        // Připnuté projekty mají přednost
        usort($projects, function ($a, $b) use ($pinnedIds) {
            $aPinned = in_array($a['id'], $pinnedIds) ? 0 : 1;
            $bPinned = in_array($b['id'], $pinnedIds) ? 0 : 1;
            return $aPinned <=> $bPinned;
        });
        ?>

        <div class="row g-3" data-masonry='{"percentPosition": true }'>
            <?php foreach ($projects as $project): ?>
                <?php
                $id = $project['id'] ?? 0;
                $title = htmlspecialchars($project['title'] ?? '');
                $description = htmlspecialchars($project['shortDescription'] ?? '');


                // 🧠 TAGY - Zpracování tagů, aby byly malá písmena, trim a bez HTML entit
                $rawTags = $project['tags'] ?? '';
                if (is_string($rawTags)) {
                    $tagsArray = array_map('trim', explode(',', $rawTags));
                } elseif (is_array($rawTags)) {
                    $tagsArray = $rawTags;
                } else {
                    $tagsArray = [];
                }

                $tagsArray = array_map(function ($tag) {
                    return strtolower(strip_tags(trim($tag)));
                }, $tagsArray);

                $dataTech = implode(',', $tagsArray);

                // 🧠 STATUS / VERSION (badge)
                $badgeKeys = $project['status'] ?? [];
                $versionArray = array_map(function ($status) {
                    return strtolower(strip_tags(trim($status)));
                }, $badgeKeys);
                $dataVersion = implode(',', $versionArray);

                // 🖼️ Thumbnail
                $thumbnail = $project['thumbnail'] ?? ($project['gallery'][0] ?? 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKAAAAA5CAYAAABxNnTaAAAAFElEQVR4nO3BMQEAAAgDoJvcf+FAAFY7gW8FAAAAAAAAAAAAAPA3A9MNAAEKCcAAAAASUVORK5CYII=');

                ?>
                <a href="detail.php?id=<?= $id ?>" target="_blank" class="project col-lg-3 col-md-4 col-sm-6 col-12 d-flex"
                    data-tech="<?= htmlspecialchars($dataTech) ?>" data-version="<?= htmlspecialchars($dataVersion) ?>">
                    <div class="card bg-dark text-light flex-fill">
                        <div class="ratio ratio-16x9">
                            <img src="portfolio/gallery/<?= $thumbnail ?>" aria-label="Náhled projektu: <?= $title ?>"
                                alt="<?= $title ?>" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover">
                        </div>
                        <div class="card-body flex-column" style="display: flex">
                            <h5 class="card-title"><?= $title ?></h5>
                            <p class="card-text flex-grow-1"><?= $description ?></p>
                            <div class="justify-content-between align-items-center mt-auto flex-wrap" style="display: flex">
                                <div class="flex-wrap w-100" style="display: flex">
                                    <?php foreach ($badgeKeys as $key): ?>
                                        <?php if (isset($badgesMap[$key])):
                                            $b = $badgesMap[$key]; ?>
                                            <span
                                                class="badge bg-<?= htmlspecialchars($b['statusBackgroundColor']) ?> text-<?= htmlspecialchars($b['statusTextColor']) ?> me-1"
                                                data-bs-tooltip="tooltip" data-bs-placement="left"
                                                title="<?= htmlspecialchars($b['statusDescription']) ?>">
                                                <?= htmlspecialchars($b['statusLabel']) ?>
                                            </span>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                                <span class="project-link mt-2 text-nowrap ms-auto">[Zobrazit více]</span>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <?php
        /*
        <!-- Rozbalovací část - Portfolio -->
        <div class="collapse mt-3" id="collapsePortfolio">
            <div class="row">
                <a href="detail.php?id=3" target="_blank" class="project col-md-6 col-lg-4 d-flex">
                    <div class="card text-light h-100 w-100">
                        <img src="https://via.placeholder.com/300" loading="lazy" class="card-img-top"
                            alt="Další projekt 1">
                        <div class="card-body">
                            <h5 class="card-title">Příklad projektu 2</h5>
                            <p class="card-text">Popis čtvrtého projektu.</p>
                            <span class="project-link">[Zobrazit více]</span>
                        </div>
                    </div>
                </a>
                <a href="detail.php?id=4" target="_blank" class="project col-md-6 col-lg-4 d-flex">
                    <div class="card text-light h-100 w-100">
                        <img src="https://via.placeholder.com/300" loading="lazy" class="card-img-top"
                            alt="Další projekt 2">
                        <div class="card-body">
                            <h5 class="card-title">Příklad projektu 3</h5>
                            <p class="card-text">Popis pátého projektu.</p>
                            <span class="project-link">[Zobrazit více]</span>
                        </div>
                    </div>
                </a>
                <a href="detail.php?id=5" target="_blank" class="project col-md-6 col-lg-4 d-flex">
                    <div class="card text-light h-100 w-100">
                        <img src="https://via.placeholder.com/300" loading="lazy" class="card-img-top"
                            alt="Další projekt 3">
                        <div class="card-body">
                            <h5 class="card-title">Příklad projektu 4</h5>
                            <p class="card-text">Popis šestého projektu.</p>
                            <span class="project-link">[Zobrazit více]</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
         */ ?>
    </div>

    <script src="portfolio/js/portfolio-filter.js"></script>

</section>