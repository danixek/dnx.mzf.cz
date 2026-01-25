<!-- Sekce Portfolio -->
<section id="portfolio" class="<?= getBgClass() ?> text-white main">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">

            <?php
            // Načteme databázi
            require 'auth/pdo.php';

            $stmt = pdo()->query("
                SELECT p.id, p.title, p.short_description, p.tags, p.thumbnail, GROUP_CONCAT(b.id SEPARATOR ',') AS badges,
                b.status_background_color, b.status_text_color
                FROM projects p
                LEFT JOIN project_badges pb ON pb.project_id = p.id
                LEFT JOIN badges b ON b.id = pb.badge_id
                GROUP BY p.id;
            ");

            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC); // pole projektů
            
            // 2️⃣ Načti všechny badge zvlášť
            $stmtBadges = pdo()->query("
                SELECT *
                FROM badges
            ");
            $badgesMap = [];
            foreach ($stmtBadges->fetchAll(PDO::FETCH_ASSOC) as $badge) {
                $badgesMap[$badge['id']] = $badge;
            }
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
                $stmt = pdo()->query("SELECT COUNT(*) FROM projects");
                $totalProjects = (int) $stmt->fetchColumn();
                ?>
                <a href="add.php" class="btn btn-themed bg-dark d-flex align-items-center">
                    <i class="bi bi-plus-lg me-2"></i>
                    Přidat projekt
                </a>
                <div id="results-count" class="d-flex align-items-center ms-auto">
                    <strong>Výsledků:</strong> <span id="project-count" class="ms-1 me-1"><?= $totalProjects ?></span>
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
                                <?php
                                foreach ($badgesMap as $badgeKey => $badge): ?>
                                    <tr>
                                        <td>
                                            <span
                                                class="badge fw-bold bg-<?= htmlspecialchars($badge['status_background_color']) ?> text-<?= htmlspecialchars($badge['status_text_color']) ?>">
                                                <?= htmlspecialchars($badge['status_label']) ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($badge['status_description']) ?></td>
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
                                            title="Filtrace tagů: všechny vybrané musí být (AND)">AND</small>
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
                                            aria-checked="mixed" role="checkbox" data-tech="api"
                                            data-filter-state="null" id="filterApi">
                                            <input type="checkbox" class="form-check-input filter-tristate-checkbox"
                                                id="filterApi-checkbox" hidden>
                                            <span class="custom-checkbox"></span>
                                            <label for="filterApi-checkbox" data-bs-tooltip="tooltip"
                                                title="Rozhraní pro komunikaci mezi aplikacemi">API</label>
                                        </div>
                                    </div>
                                    <div class="checkbox-grid">
                                        <div class="form-check filter-tristate-wrapper" tabindex="0"
                                            aria-checked="mixed" role="checkbox" data-tech="bootstrap"
                                            data-filter-state="null" id="filterBootstrap">
                                            <input type="checkbox" class="form-check-input filter-tristate-checkbox"
                                                id="filterBootstrap-checkbox" hidden>
                                            <span class="custom-checkbox"></span>
                                            <label for="filterBootstrap-checkbox" data-bs-tooltip="tooltip"
                                                title="CSS framework pro rychlou tvorbu moderních a responzivních webů">Bootstrap</label>
                                        </div>
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
                                        <h5>Stav projektu</h5>
                                        <small class="text-muted-darkmode ms-auto" data-bs-tooltip="tooltip"
                                            data-bs-placement="top"
                                            title="Filtrace štítků: stačí jedna vybraná (OR)">OR</small>
                                    </div>
                                    <div class="checkbox-grid">
                                        <?php foreach ($badgesMap as $badgeKey => $badge): ?>
                                            <div class="form-check filter-tristate-wrapper" tabindex="0"
                                                aria-checked="mixed" role="checkbox"
                                                data-version="<?= htmlspecialchars($badge['status_label']) ?>"
                                                data-filter-state="null" id="filter<?= ucfirst($badgeKey) ?>">

                                                <input type="checkbox" class="form-check-input filter-tristate-checkbox"
                                                    id="filter<?= ucfirst($badgeKey) ?>-checkbox" hidden>
                                                <span class="custom-checkbox"></span>

                                                <label for="filter<?= ucfirst($badgeKey) ?>-checkbox"
                                                    data-bs-tooltip="tooltip"
                                                    title="<?= htmlspecialchars($badge['status_description']) ?>">
                                                    <span class="badge fw-bold bg-<?= htmlspecialchars($badge['status_background_color']) ?>
                                                    text-<?= htmlspecialchars($badge['status_text_color']) ?> mb-1">
                                                        <?= htmlspecialchars($badge['status_label']) ?>
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

        <div class="row g-3">
            <?php foreach ($projects as $project): ?>
                <?php
                $id = $project['id'] ?? 0;
                $title = htmlspecialchars($project['title'] ?? '');
                $description = htmlspecialchars($project['short_description'] ?? '');

                // 🧠 TAGY - Zpracování tagů, aby byly malá písmena, trim a bez HTML entit
                $rawTags = explode(', ', $project['tags']) ?? '';
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

                // 🧠 STATUS - VERSION (badge)
                $badgeKeys = explode(',', $project['badges']);

                $versionArray = array_map(function ($status) {
                    return strtolower(strip_tags(trim($status)));
                }, $badgeKeys);
                $dataVersion = implode(',', $versionArray);

                // 🖼️ Thumbnail
                $defaultBase64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKAAAAA5CAYAAABxNnTaAAAAFElEQVR4nO3BMQEAAAgDoJvcf+FAAFY7gW8FAAAAAAAAAAAAAPA3A9MNAAEKCcAAAAASUVORK5CYII=';

                $thumbnailFile = $project['thumbnail'] ?? ($project['gallery'][0] ?? null);

                if ($thumbnailFile) {
                    $publicPath = '/DEVportfolio/gallery/' . ltrim($thumbnailFile, '/');
                    $fullPath = $_SERVER['DOCUMENT_ROOT'] . $publicPath;

                    if (file_exists($fullPath)) {
                        $thumbnail = $publicPath;
                    } else {
                        $thumbnail = $defaultBase64;
                    }
                } else {
                    $thumbnail = $defaultBase64;
                }

                ?>
                <a href="detail.php?id=<?= $id ?>" class="project col-lg-3 col-md-4 col-sm-6 col-12 d-flex"
                    data-tech="<?= htmlspecialchars($dataTech) ?>" data-version="<?= htmlspecialchars($dataVersion) ?>">
                    <div class="card bg-dark text-light flex-fill d-flex flex-column position-relative">
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <!-- Admin icons -->
                            <div class="position-absolute top-0 start-0 d-flex m-2">
                                <span class="admin-btn-ico pin-btn" title="Připnout">
                                    <i class="bi bi-pin-angle"></i>
                                </span>
                            </div>

                            <div class="position-absolute top-0 end-0 m-2 d-flex gap-1">
                                <span class="admin-btn-ico edit-btn" title="Upravit">
                                    <i class="bi bi-pencil"></i>
                                </span>
                                <span class="admin-btn-ico delete-btn" title="Smazat">
                                    <i class="bi bi-x-lg"></i>
                                </span>
                            </div>

                        <?php endif; ?>
                        <div class="ratio ratio-16x9">
                            <img src="<?= $thumbnail ?>" aria-label="Náhled projektu: <?= $title ?>" alt="<?= $title ?>"
                                class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover">
                        </div>
                        <div class="card-body flex-column" style="display: flex">
                            <h5 class="card-title"><?= $title ?></h5>
                            <p class="card-text flex-grow-1"><?= $description ?></p>
                            <div class="justify-content-between align-items-center mt-auto flex-wrap" style="display: flex">
                                <div class="flex-wrap w-100" style="display: flex">
                                    <?php

                                    foreach ($badgeKeys as $key) { ?>
                                        <?php if (isset($badgesMap[$key]) && $badgesMap[$key]['status_visible'] == "visible"):

                                            $b = $badgesMap[$key]; ?>
                                            <span
                                                class="badge fw-bold bg-<?= htmlspecialchars($b['status_background_color']) ?> text-<?= htmlspecialchars($b['status_text_color']) ?> mt-1 me-1"
                                                data-bs-tooltip="tooltip" data-bs-placement="left" style="font-weight: bold"
                                                title="<?= htmlspecialchars($b['status_description']) ?>">
                                                <?= htmlspecialchars($b['status_label']) ?>
                                            </span>
                                        <?php endif; ?>
                                    <?php } ?>
                                </div>
                                <span class="project-link mt-2 text-nowrap ms-auto">[Zobrazit více]</span>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach;
            if ($_SESSION['role'] === 'admin'): ?>
                <a href="" class="project col-lg-3 col-md-4 col-sm-6 col-12 d-flex">
                    <div class="card card-body add-card text-light flex-fill">
                        <div class="add-card-content">
                            <i class="bi bi-plus-lg pt-3"></i>
                            <span class="bold fs-5 pb-3">Přidat projekt</span>
                        </div>
                    </div>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <script src="/DEVportfolio/js/portfolio-filter.js"></script>

</section>