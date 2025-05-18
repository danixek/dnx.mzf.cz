<!DOCTYPE html>
<html lang="cs">

<?php include 'portfolio/partials/header.php'; ?>

<body>

    <header>
        <?php

        // Navigační menu
        require('portfolio/partials/navbar.php');

        // Utilita v PHP na přepínání barev frontendu - CSS přepínač
        require('portfolio/utils.php'); ?>

        <!-- Sekce domů - speciální verze bez citátů -->
        <section id="home" class="<?= getBgClass() ?> text-center text-white pt-4">
            <div class="container mt-5 pt-4">
                <h1 class="display-4">Hello, I'm a Programmer</h1>
                <p class="lead pt-4">Vytvářím řešení pomocí C#, ASP.NET, WPF a JavaScriptu pro rozšíření
                    svého portfolia.</p>
            </div>
        </section>
    </header>
    <main>
        <?php
        // Načteme JSON soubor
        $data = json_decode(file_get_contents('portfolio/portfolio.json'), true);
        $projects = $data['projects'] ?? [];
        $badgesMap = $data['badges'] ?? [];


        // Získáme id z URL (pokud existuje)
        $projectId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        // Vyhledání projektu
        $selectedProject = null;
        foreach ($projects as $project) {
            if ($project['id'] === $projectId) {
                $selectedProject = $project;
                break;
            }
        }

        if ($selectedProject === null) {
            echo "Projekt nenalezen.";
            exit;
        }
        ?>

        <!-- Sekce Detail - detail portfolia -->
        <section id="detail" class="<?= getBgClass() ?> py-5 text-white">
            <div class="container">
                <div class="row align-items-start">
                    <!-- Galerie vlevo -->
                    <div class="col-md-4 mb-4 mb-md-0" id="gallery"
                        data-gallery='<?= json_encode($selectedProject['gallery']) ?>'>
                        <div>
                            <?php if (!empty($selectedProject['gallery'])): ?>
                                <!-- Hlavní obrázek (kliknutím na něj otevřeš modal) -->
                                <img id="mainImage"
                                    src="<?= htmlspecialchars($selectedProject['gallery'][0]) ?? 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKAAAAA5CAYAAABxNnTaAAAAFElEQVR4nO3BMQEAAAgDoJvcf+FAAFY7gW8FAAAAAAAAAAAAAPA3A9MNAAEKCcAAAAASUVORK5CYII=' ?>"
                                    class="img-fluid rounded mb-3 detail-mainimg" loading="lazy" alt="Hlavní obrázek"
                                    data-bs-toggle="modal" data-bs-target="#imageModal"
                                    style="max-width: 100%; max-height: 400px; object-fit: contain;">
                                <div class="row g-2">
                                    <?php foreach ($selectedProject['gallery'] as $index => $image): ?>
                                        <div class="col-4 col-md-2 thumb-wrapper"> <!-- 3 sloupce na xs, 6 sloupců na md -->
                                            <img src="<?= htmlspecialchars($image) ?>" class="img-thumbnail w-100"
                                                style="height: 60px; cursor: pointer; object-fit: cover;"
                                                onclick="changeMainImage(this)" loading="lazy" data-index="<?= $index ?>"
                                                alt="Náhled <?= $index ?>">
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                            <?php else: ?>
                                <p class="text-muted">Galerie není k dispozici.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Modal pro zobrazení zvětšeného obrázku -->
                        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content bg-dark text-white">
                                    <div class="modal-header d-flex align-items-center">
                                        <h5 class="modal-title" id="imageModalLabel">Galerie projektu</h5>
                                        <button type="button" class="btn-close gallery-btn-close btn-close-white"
                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-0"><!-- odstraněny paddingy, aby obrázek zabral maximum -->
                                        <img id="modalImage"
                                            src="<?= htmlspecialchars($selectedProject['gallery'][0]) ?>"
                                            class="img-fluid w-100" loading="lazy" alt="Detail obrázku"
                                            style="max-width:100%; max-height: 90vh; object-fit: contain;"><!-- omezení výšky na 90% viewportu -->
                                        <button type="button"
                                            class="btn btn-dark btn-gallery position-absolute top-50 start-0 translate-middle-y"
                                            id="prevImageBtn">&lt;&nbsp;</button>
                                        <button type="button"
                                            class="btn btn-dark btn-gallery position-absolute top-50 end-0 translate-middle-y"
                                            id="nextImageBtn">&nbsp;&gt;</button>
                                        <!-- JS skripty ke galerii -->
                                        <script src="portfolio/js/detail-gallery.js"></script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Informace vpravo -->
                    <div class="col-md-8">
                        <!-- Nadpis + status (version) badge + verze -->
                        <div class="d-flex align-items-center mb-2">
                            <h2 class="project-title mb-0 me-3">
                                <?= htmlspecialchars($selectedProject['title']) ?>
                            </h2>

                            <!-- Status badge, aneb verze projektu -->
                            <?php if (!empty($selectedProject['status'])): ?>
                                <?php foreach ($selectedProject['status'] as $key): ?>
                                    <?php if (isset($badgesMap[$key])):
                                        $b = $badgesMap[$key]; ?>
                                        <span
                                            class="badge bg-<?= htmlspecialchars($b['statusBackgroundColor']) ?> text-<?= htmlspecialchars($b['statusTextColor']) ?> me-2"
                                            data-bs-tooltip="tooltip" data-bs-placement="top"
                                            title="<?= htmlspecialchars($b['statusDescription']) ?>">
                                            <?= htmlspecialchars($b['statusLabel']) ?>
                                        </span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <!-- Verze jako badge -->
                            <?php if (!empty($selectedProject['version'])): ?>
                                <span class="badge text-white ms-2" data-bs-tooltip="tooltip" data-bs-placement="top"
                                    title="Verze projektu: v<?= htmlspecialchars($selectedProject['version']) ?>">
                                    v<?= htmlspecialchars($selectedProject['version']) ?>
                                </span>
                            <?php endif; ?>

                        </div>

                        <!-- Popisek projektu -->
                        <p class="project-description mt-3">
                            <?= nl2br(html_entity_decode(htmlspecialchars($selectedProject['description']))) ?>
                        </p>

                        <!-- Poznámka "pod čarou" k popisku -->
                        <?php if (!empty($selectedProject['note'])): ?>
                            <p class="text-warning fw-bold mt-4">
                                <?= nl2br(html_entity_decode(htmlspecialchars($selectedProject['note']))) ?>
                            </p>
                        <?php endif; ?>


                        <!-- Tagy (použité technologie) + datum dokončení dané verze -->
                        <?php if (!empty($selectedProject['tags']) || !empty($selectedProject['completionDate'])): ?>

                            <div class="mb-3 d-flex flex-wrap gap-2 mt-4 mb-4">
                                <?php if (!empty($selectedProject['completionDate'])): ?>

                                    <?php
                                    $formattedDate = '';
                                    if (!empty($selectedProject['completionDate'])) {
                                        $months = [
                                            '01' => 'leden',
                                            '02' => 'únor',
                                            '03' => 'březen',
                                            '04' => 'duben',
                                            '05' => 'květen',
                                            '06' => 'červen',
                                            '07' => 'červenec',
                                            '08' => 'srpen',
                                            '09' => 'září',
                                            '10' => 'říjen',
                                            '11' => 'listopad',
                                            '12' => 'prosinec'
                                        ];
                                        $parts = explode('-', $selectedProject['completionDate']);
                                        if (count($parts) === 2) {
                                            [$year, $month] = $parts;
                                            if (isset($months[$month])) {
                                                $formattedDate = $months[$month] . ' ' . $year;
                                            }
                                        }
                                    }
                                    ?>

                                    <?php if (!empty($formattedDate)): ?>
                                        <span class="badge" data-bs-tooltip="tooltip" data-bs-placement="top"
                                            title="Datum poslední změny: <?= htmlspecialchars($formattedDate) ?>">
                                            <i class="bi bi-calendar-event me-1"></i>
                                            <?= htmlspecialchars($formattedDate) ?>
                                        </span>
                                    <?php endif; ?>

                                <?php endif; ?>

                                <?php foreach (explode(',', $selectedProject['tags']) as $tag): ?>
                                    <span class="badge bg-secondary"><?= htmlspecialchars(trim($tag)) ?></span>
                                <?php endforeach; ?>

                            </div>
                        <?php endif; ?>


                        <!-- Odkazy ke stažení - začátek -->
                        <div class="d-flex flex-wrap align-items-center mt-4">
                            <?php
                            // Přemapuje to seznam linků na asociativní pole podle typu
                            $linkMap = [];
                            foreach ($selectedProject['links'] as $link) {
                                if (!empty($link['type']) && !empty($link['url'])) {
                                    $linkMap[$link['type']] = $link['url'];
                                }
                            }

                            // GitHub – malé tlačítko
                            if (!empty($linkMap['github'])) {
                                $gitUrl = $linkMap['github'];
                                $gitIcon = 'bi-github';
                                $gitLabel = 'GitHub';

                                // Rozlišení GitHub vs GitLab
                                if (stripos($gitUrl, 'gitlab.com') !== false) {
                                    $gitIcon = 'bi-gitlab';
                                    $gitLabel = 'GitLab';
                                } elseif (stripos($gitUrl, 'github.com') === false) {
                                    // Není to GitHub či GitLab =>externí odkaz
                                    $gitIcon = 'bi-code';  // Např. pro jiný externí odkaz
                                    $gitLabel = 'Externí Repo';  // Nebo jakýkoli jiný název
                                }

                                echo '<a href="' . htmlspecialchars($gitUrl) . '" target="_blank" rel="noopener noreferrer" class="btn btn-md btn-outline-light me-2">';
                                echo '<i class="bi ' . $gitIcon . ' me-1"></i>' . $gitLabel . '</a>';
                            }

                            // Preview má přednost před Download – velké tlačítko
                            if (!empty($linkMap['preview'])) {
                                echo '<a href="' . htmlspecialchars($linkMap['preview']) . '" target="_blank" rel="noopener noreferrer" class="btn btn-lg btn-primary ms-3">';
                                echo '<i class="bi bi-box-arrow-up-right me-1"></i>Náhled</a>';
                            } elseif (!empty($linkMap['download'])) {
                                echo '<a href="' . htmlspecialchars($linkMap['download']) . '" download class="btn btn-lg btn-success ms-3">';
                                echo '<i class="bi bi-download me-1"></i>Stáhnout projekt</a>';
                            }
                            ?>
                            <!-- Collapse tlačítko na odkrytí changelogu -->
                            <button class="btn btn-outline-secondary ms-auto" type="button" data-bs-tooltip="tooltip"
                                data-bs-placement="top" title="changelog" data-bs-toggle="collapse"
                                data-bs-target="#changelogCollapse" aria-expanded="false"
                                aria-controls="changelogCollapse">
                                <i class="bi bi-journal-text"></i>
                            </button>


                        </div>
                        <!-- Odkazy ke stažení - konec -->

                        <!-- Collapse obsah - Changelog -->
                        <div class="collapse mt-4" id="changelogCollapse">
                            <div class="card card-body" style="background-color: rgba(30, 30, 30, 0.5)">
                                <h5>Changelog</h5>
                                <?php if (!empty($selectedProject['changelog'])): ?>
                                    <ul class="mb-0" style="list-style-type: disc; padding-left: 1.15rem;">
                                        <?php

                                        foreach ($selectedProject['changelog'] as $item):
                                            $formattedDate = '';
                                            if (!empty($item['date'])) {
                                                $date = DateTime::createFromFormat('Y-m', $item['date']);
                                                if ($date) {
                                                    $formattedDate = $date->format('F Y');
                                                    $formattedDate = str_replace(
                                                        ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                                                        ['leden', 'únor', 'březen', 'duben', 'květen', 'červen', 'červenec', 'srpen', 'září', 'říjen', 'listopad', 'prosinec'],
                                                        $formattedDate
                                                    );
                                                }
                                            }

                                            $noteLines = explode("\n", $item['notes']);
                                            ?>
                                            <li>
                                                <div class="d-flex justify-content-between">
                                                    <strong>Verze <?= htmlspecialchars($item['version']) ?></strong>
                                                    <?php if (!empty($formattedDate)): ?>
                                                        <small class="text-muted-darkmode"><?= $formattedDate ?></small>
                                                    <?php endif; ?>
                                                </div>

                                                <?php if (!empty($noteLines)): ?>
                                                    <ul class="notes-list">
                                                        <?php foreach ($noteLines as $line): ?>
                                                            <li><small><?= htmlspecialchars($line) ?></small></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>



                                <?php else: ?>
                                    <p class="text-muted-darkmode mb-0">Zatím žádné změny.</p>
                                <?php endif; ?>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </section>

    </main>
    <footer>
        <?php
        // Citáty
        require('portfolio/partials/quotes.php');

        // Kontakt
        require('portfolio/partials/contacts.php'); ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="portfolio/js/quotes.js"></script>
    <script src="portfolio/js/bs-tooltip.js"></script>


</body>

</html>