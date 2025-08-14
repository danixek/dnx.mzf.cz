<!DOCTYPE html>
<html lang="cs">

<?php include '../partials/header.php'; ?>
<?php include '../logging.php'; ?>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-J4QB2029QQ"></script>
<script>
window.dataLayer = window.dataLayer || [];

function gtag() {
    dataLayer.push(arguments);
}
gtag('js', new Date());

gtag('config', 'G-J4QB2029QQ');
</script>

<body id="page-wrapper">
    <header>
        <?php
        // Navigační menu
        require('../partials/navbar.php');

        // Utilita v PHP na přepínání barev frontendu - CSS přepínač
        require('../utils.php');

        // Domů - nadpis, podnadpis a citáty
        require('../portfolio/partials/home.php'); ?>
    </header>
    <main>
        <!-- Sekce domů -->
        <section id="library" class="<?= getBgClass() ?> text-white">
            <div class="container">

                <h2 class="section-title me-3 mb-3">Knihovna - Moje doporučení</h2>
                <span class="alert text-center mb-0 d-flex" style="border-left: 3px solid rgb(155, 155, 155); border-radius: 0">Tato podstránka je stále ve vývoji.</span>
                <p class="mt-3">Tady jsou k nalezení věci, které mě nějak zasáhly, zaujaly, inspirovaly nebo prostě jen bavily.</p>
                <div class="text-center">
                    <div class="btn-group">
                        <a href="?l=0" class="btn btn-themed d-flex align-items-center">
                            <i class="bi bi-lightbulb me-2"></i> Přednášky
                        </a>
                        <a href="?l=1" class="btn btn-themed d-flex align-items-center">
                            <i class="bi bi-collection-play me-2"></i> Filmy+
                        </a>
                        <a href="?l=2" class="btn btn-themed d-flex align-items-center">
                            <i class="bi bi-controller me-2"></i> Hry
                        </a>
                    </div>
                </div>

<div class="my-4">
    <?php
    $jsonFile = __DIR__ . DIRECTORY_SEPARATOR . 'library.json';

    if (!file_exists($jsonFile)) {
        echo "<p>⚠️ Soubor library.json neexistuje.</p>";
        return;
    }

    $data = json_decode(file_get_contents($jsonFile), true);

    if (!is_array($data)) {
        echo "<p>⚠️ Chybný formát dat.</p>";
        return;
    }

    $map = [
        0 => 'Přednášky',
        1 => 'Filmy+',
        2 => 'Hry'
    ];

    $l = isset($_GET['l']) ? intval($_GET['l']) : 0;
    $selectedCategory = $map[$l] ?? null;

    if (!$selectedCategory || !isset($data[$selectedCategory])) {
        $selectedCategory = $map[$l] ?? null;
        return;
    }

    $items = $data[$selectedCategory];

    echo "<h2>$selectedCategory</h2>";
    ?>
    
    <div class="row g-3 mt-2">
        <?php foreach ($items as $item): 

            // ⚠️ PŘESKOČ, pokud má "visibility: hidden"
            if (($item['visibility'] ?? 'visible') === 'hidden') continue;

            $id = $item['id'] ?? 0;
            $title = htmlspecialchars($item['title'] ?? '');
            $description = htmlspecialchars($item['shortDescription'] ?? '');

            // 🏷️ TAGY
            $rawTags = $item['tags'] ?? [];
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

            // 🖼️ THUMBNAIL
            $defaultBase64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKAAAAA5CAYAAABxNnTaAAAAFElEQVR4nO3BMQEAAAgDoJvcf+FAAFY7gW8FAAAAAAAAAAAAAPA3A9MNAAEKCcAAAAASUVORK5CYII=';

            $thumbnailFile = $item['thumbnail'] ?? ($item['gallery'][0] ?? null);
            if ($thumbnailFile) {
                $publicPath = '/library/gallery/' . ltrim($thumbnailFile, '/');
                $fullPath = $_SERVER['DOCUMENT_ROOT'] . $publicPath;
                $thumbnail = file_exists($fullPath) ? $publicPath : $defaultBase64;
            } else {
                $thumbnail = $defaultBase64;
            }
        ?>
            <? // původní url --  href="detail.php?id= php $id " ?>
            <a href<?php if (isset($item['url'])) { echo '="'. $item['url'] . '"'; } ?> class="project col-lg-3 col-md-4 col-sm-6 col-12 d-flex"
               data-tech="<?= htmlspecialchars($dataTech) ?>">
                <div class="card bg-dark text-light flex-fill" style="background-color: rgb(0,0,0,0.22) !important">
                    <div class="ratio ratio-16x9">
                        <img src="<?= $thumbnail ?>" aria-label="Náhled projektu: <?= $title ?>"
                             alt="<?php if (mb_strlen($title) > 21) { echo substr($title, 0, 21) . "...";} else { echo $title;} ?>"
                             class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover">
                    </div>
                    <div class="card-body flex-column d-flex">
                        <h5 class="card-title"><?php if (mb_strlen($title) > 21) { echo substr($title, 0, 21) . "...";} else { echo $title;} ?></h5>
                        <p class="card-text flex-grow-1" style="display: none"><?= $description ?></p>
                        <div class="justify-content-between align-items-center mt-auto d-flex flex-wrap">
                            <span class="project-link mt-2 text-nowrap ms-auto" style="display: none">[Zobrazit více]</span>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>



                <a href="/" class="btn btn-themed mt-3">Zpět na domovskou stránku</a>
        </section>
    </main>

    <footer>
        <?php
        // Kontakt
        require('../partials/contacts.php'); ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/quotes.js"></script>
    <script src="/js/bs-tooltip.js"></script>

</body>

</html>