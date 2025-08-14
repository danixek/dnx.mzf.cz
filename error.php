<!DOCTYPE html>
<html lang="cs">

<?php include 'partials/header.php'; ?>
<?php
// cesta k log souboru (ujisti se, že má PHP právo zapisovat)
$logFile = __DIR__ . '/logs/visits.log';

// datum a čas
$date = date("Y-m-d H:i:s");

// aktuální stránka (např. /kontakt nebo /index.php)
$userLocation = $_SERVER['REQUEST_URI'];

// IP adresa a prohlížeč
$ip = $_SERVER['REMOTE_ADDR'];
$ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
// řádek do logu
$logLine = "[$date] - Error page $userLocation - IP: $ip - UA: $ua" . PHP_EOL;

// přidání do souboru
file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);
?>

<body>

    <header>
        <?php

        // Navigační menu
        require('partials/navbar.php');

        // Utilita v PHP na přepínání barev frontendu - CSS přepínač
        require('utils.php'); ?>

        <!-- Sekce domů - speciální verze bez citátů -->
        <section id="home" class="<?= getBgClass() ?> text-center text-white pt-4">
            <div class="container mt-5 pt-4">
                <h1 class="display-1">[ <span class="d-inline-block" style="position: relative; top: 10px">d</span>]
                </h1>
                <p class="lead pt-3">Chcete se vrátit na domovskou stránku?</p>
                <a href="/" class="lead d-inline-block">[Klik]</a>
            </div>
        </section>
    </header>
    <main>
        <?php
        // error.php
        
        // Defaultní kód, pokud není zadán
        $code = $_GET['code'] ?? 404;

        $errors = [
            403 => ['title' => 'Přístup zamítnut', 'message' => 'Nemáš tu co dělat...'],
            404 => ['title' => 'Nenalezeno', 'message' => 'Smysl [života] nenalezen.'],
            500 => ['title' => 'Chyba serveru', 'message' => 'Něco se uvnitř pokazilo.'],
            418 => ['title' => 'I\'m a teapot', 'message' => 'Jsem čajová konvice, ne kávovar. ☕️']
        ];

        $error = $errors[$code] ?? $errors[404]; // Fallback na 404
        ?>

        <!-- Sekce Blog -->
        <section id="error" class="<?= getBgClass() ?> py-5 text-white">
            <div class="container">
                <div class="row text-center">
                    <h2 class="display-5 pt-4">Error <?= htmlspecialchars($code) ?></h2>
                    <p class="lead pt-2"><?= htmlspecialchars($error['message']) ?></p>
                </div>
            </div>

        </section>

    </main>
    <footer>
        <?php
        // Citáty
        require('partials/quotes.php');

        // Kontakt
        require('partials/contacts.php'); ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/quotes.js"></script>
    <script src="/js/bs-tooltip.js"></script>


</body>

</html>