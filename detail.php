<!DOCTYPE html>
<html lang="cs">

<?php include 'DEVportfolio/partials/header.php'; ?>

<body>

    <header>
        <?php

        // Navigační menu
        require('DEVportfolio/partials/navbar.php');

        // Utilita v PHP na přepínání barev frontendu - CSS přepínač
        require('DEVportfolio/utils.php'); ?>

        <!-- Sekce domů - speciální verze bez citátů -->
        <section id="home" class="<?= getBgClass() ?> text-center text-white pt-4">
            <div class="container mt-5 pt-4">
                <h1 class="display-4">Hello, I'm a Programmer</h1>
                <p class="lead pt-4">Vytvářím řešení pomocí C#, ASP.NET a WPF;<br>
                    od backendu po rozhraní</p>
            </div>
        </section>
    </header>
    <main>
        <?php
        // Načteme databázi
        require 'auth/pdo.php';

        // Získáme id z URL (pokud existuje)
        $projectId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        $stmt = pdo()->prepare("
            SELECT 
                p.*,
            GROUP_CONCAT(b.id SEPARATOR ',') AS status
            FROM projects p
            LEFT JOIN project_badges pb ON pb.project_id = p.id    
            LEFT JOIN badges b ON b.id = pb.badge_id
            WHERE p.id = ?
            GROUP BY p.id
        ");
        $stmt->execute([$projectId]);

        $project = $stmt->fetch(PDO::FETCH_ASSOC); // pole projektů
        // 2) Načteme links, gallery a changelog s klíčem
        $linksStmt = pdo()->prepare("SELECT id, type, url FROM project_links WHERE project_id = ?");
        $linksStmt->execute([$projectId]);
        $links = $linksStmt->fetchAll(PDO::FETCH_ASSOC);

        $galleryStmt = pdo()->prepare("SELECT * FROM project_gallery WHERE project_id = ?");
        $galleryStmt->execute([$projectId]);
        $gallery = $galleryStmt->fetchAll(PDO::FETCH_ASSOC);

        $changelogStmt = pdo()->prepare("SELECT * FROM project_changelog WHERE project_id = ?");
        $changelogStmt->execute([$projectId]);
        $changelog = $changelogStmt->fetchAll(PDO::FETCH_ASSOC);

        $stmtBadges = pdo()->query("
            SELECT *
            FROM badges
        ");

        // 3) Převod do asociativního pole podle id (zachování klíče)

        $linksAssoc = [];
        foreach ($links as $link) {
            $linksAssoc[] = $link; // id = klíč
        }

        $galleryAssoc = [];
        foreach ($gallery as $projectImage) {
            $galleryAssoc[] = $projectImage['image']; // id = klíč
        }
        $changelogAssoc = [];
        foreach ($changelog as $log) {
            $changelogAssoc[] = $log; // id = klíč
        }
        
        $badgesMap = [];
        foreach ($stmtBadges->fetchAll(PDO::FETCH_ASSOC) as $badge) {
            $badgesMap[$badge['id']] = $badge;
        }

        // 4) Vložíme do projektu
        $project['links'] = $linksAssoc;
        $project['gallery'] = $galleryAssoc;
        $project['changelog'] = $changelogAssoc;
        $project['status'] = array_map('trim', explode(',', $project['status']));

        if ($project === false) {
            echo "Projekt nenalezen.";
            exit;
        }
        ?>
        <?php include 'DEVportfolio/logger.php'; ?>

        <!-- Sekce Detail - detail portfolia -->
        <section id="detail" class="<?= getBgClass() ?> py-5 text-white">
            <div class="container">
                <div class="row align-items-start">
                    <!-- Galerie vlevo -->
                    <div class="col-md-4 mb-4 mb-md-0" id="gallery"
                        data-gallery='<?= json_encode($project['gallery']) ?>'>
                        <div>
                            <?php if (!empty($project['gallery'])): ?>
                            <!-- Hlavní obrázek (kliknutím na něj otevřeš modal) -->
                            <img id="mainImage"
                                src="DEVportfolio/gallery/<?= htmlspecialchars($project['gallery'][0]) ?? 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKAAAAA5CAYAAABxNnTaAAAAFElEQVR4nO3BMQEAAAgDoJvcf+FAAFY7gW8FAAAAAAAAAAAAAPA3A9MNAAEKCcAAAAASUVORK5CYII=' ?>"
                                class="img-fluid rounded mb-3 detail-mainimg" loading="lazy" alt="Hlavní obrázek"
                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                style="max-width: 100%; max-height: 400px; object-fit: contain; margin: 0">
                            <div class="row g-2">
                                <?php foreach ($project['gallery'] as $index => $image): ?>
                                <div class="col-4 col-md-2 thumb-wrapper">
                                    <!-- 3 sloupce na xs, 6 sloupců na md -->
                                    <img src="DEVportfolio/gallery/<?= htmlspecialchars($image) ?>"
                                        class="img-thumbnail w-100"
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
                                    <div class="modal-body p-0">
                                        <!-- odstraněny paddingy, aby obrázek zabral maximum -->
                                        <img id="modalImage"
                                            src="DEVportfolio/gallery/<?= htmlspecialchars($project['gallery'][0]) ?>"
                                            class="img-fluid w-100" loading="lazy" alt="Detail obrázku"
                                            style="max-width:100%; max-height: 90vh; object-fit: contain; margin: 0px">
                                        <!-- omezení výšky na 90% viewportu -->
                                        <button type="button"
                                            class="btn btn-dark btn-gallery position-absolute top-50 start-0 translate-middle-y"
                                            id="prevImageBtn">&lt;&nbsp;</button>
                                        <button type="button"
                                            class="btn btn-dark btn-gallery position-absolute top-50 end-0 translate-middle-y"
                                            id="nextImageBtn">&nbsp;&gt;</button>
                                        <!-- JS skripty ke galerii -->
                                        <script src="DEVportfolio/js/detail-gallery.js"></script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Informace vpravo -->
                    <div class="col-md-8">
                        <!-- Nadpis + status (version) badge + verze -->
                        <div class="d-flex flex-wrap flex-lg-nowrap align-items-center mb-2">
                            <h2 class="project-title mb-0 me-3">
                                <?= htmlspecialchars($project['title']); ?>
                            </h2>
                            <!-- Status badge, aneb verze projektu -->
                            <?php if (!empty($project['status'])): ?> 
                            <?php foreach ($project['status'] as $key): ?>
                            <?php if (isset($badgesMap[$key]) && $badgesMap[$key]['status_visible'] == "visible"):
                                        $b = $badgesMap[$key]; ?>
                            <span
                                class="badge fw-bold bg-<?= htmlspecialchars($b['status_background_color']) ?> text-<?= htmlspecialchars($b['status_text_color']) ?> me-2"
                                data-bs-tooltip="tooltip" data-bs-placement="top" style="font-weight: bold"
                                title="<?= htmlspecialchars($b['status_description']) ?>">
                                <?= htmlspecialchars($b['status_label']) ?>
                            </span>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php endif; ?>

                            <!-- Verze jako badge -->
                            <?php if (!empty($project['version'])): ?>
                            <span class="badge text-white ms-2" data-bs-tooltip="tooltip" data-bs-placement="top"
                                title="Verze projektu: v<?= htmlspecialchars($project['version']) ?>">
                                v<?= htmlspecialchars($project['version']) ?>
                            </span>
                            <?php endif; ?>

                        </div>

                        <!-- Popisek projektu -->
                        <p class="project-description mt-3">
                            <?= nl2br(html_entity_decode(htmlspecialchars($project['description']))) ?>
                        </p>

                        <!-- Poznámka "pod čarou" k popisku -->
                        <?php if (!empty($project['note'])): ?>
                        <p class="text-warning fw-bold mt-4">
                            <?= nl2br(html_entity_decode(htmlspecialchars($project['note']))) ?>
                        </p>
                        <?php endif; ?>


                        <!-- Tagy (použité technologie) + datum dokončení dané verze -->
                        <?php if (!empty($project['tags']) || !empty($project['completion_date'])): ?>

                        <div class="mb-3 d-flex flex-wrap gap-2 mt-4 mb-4">
                            <?php if (!empty($project['completion_date'])): ?>

                            <?php
                                    $formattedDate = '';
                                    if (!empty($project['completion_date'])) {
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
                                        $parts = explode('-', $project['completion_date']);
                                        if (count($parts) === 3) {
                                            [$year, $month, $day] = $parts;
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

                            <?php foreach (explode(',', $project['tags']) as $tag): ?>
                            <span class="badge fw-bold bg-secondary"><?= htmlspecialchars(trim($tag)) ?></span>
                            <?php endforeach; ?>

                        </div>
                        <?php endif; ?>


                        <!-- Odkazy ke stažení - začátek -->
                        <div class="d-flex flex-wrap align-items-center mt-4">
                            <?php
                            // Přemapuje to seznam linků na asociativní pole podle typu
                            $linkMap = [];
                            foreach ($project['links'] as $link) {
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

                                echo '<a href="' . htmlspecialchars($gitUrl) . '" target="_blank" rel="noopener noreferrer" class="btn btn-md btn-themed me-2">';
                                echo '<i class="bi ' . $gitIcon . ' me-1"></i>' . $gitLabel . '</a>';
                            }

                            // Preview má přednost před Download – velké tlačítko
                            if (!empty($linkMap['preview'])) {
                                echo '<a href="' . htmlspecialchars($linkMap['preview']) . '" target="_blank" rel="noopener noreferrer" class="btn btn-lg btn-themed ms-3">';
                                echo '<i class="bi bi-box-arrow-up-right me-1"></i>Náhled</a>';
                            } elseif (!empty($linkMap['download'])) {
                                echo '<a href="' . htmlspecialchars($linkMap['download']) . '" download class="btn btn-lg btn-themed ms-3">';
                                echo '<i class="bi bi-download me-1"></i>Stáhnout projekt</a>';
                            }
                            ?>
                            <!-- Collapse tlačítko na odkrytí changelogu -->
                            <button class="btn btn-themed ms-auto" type="button" data-bs-tooltip="tooltip"
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
                                <?php if (!empty($project['changelog'])): ?>
                                <ul class="mb-0" style="list-style-type: disc; padding-left: 1.15rem;">
                                    <?php

                                        foreach ($project['changelog'] as $item):
                                            $formattedDate = '';
                                            if (!empty($item['date'])) {
                                                $date = DateTime::createFromFormat('Y-m-d', $item['date']);
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
        require('DEVportfolio/partials/quotes.php');

        // Kontakt
        require('DEVportfolio/partials/contacts.php'); ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/DEVportfolio/js/quotes.js"></script>
    <script src="/DEVportfolio/js/bs-tooltip.js"></script>


</body>

</html>