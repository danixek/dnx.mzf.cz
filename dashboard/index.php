<!DOCTYPE html>
<html lang="cs" class="theme-dark">
<head>
    <meta charset="UTF-8" />
    <link rel="shortcut icon" href="../logo/dnx-logo_mini.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="index.css" />
    <link rel="stylesheet" href="endora-ads.css">
</head>

<body>
    <a class="logo-wrapper" href="index.php">
        <img src="../logo/dnx-logo_mini_60px.png" alt="Logo">
        <span class="logo-text">
            <span class="visually-hidden">d</span>
            <span class="logo_text-show" id="logo-text">nx</span>
        </span>
    </a>
    <?php
    session_start();
    define('IS_DEV', in_array($_SERVER['SERVER_NAME'], ['localhost', 'dnx.test']) || isset($_GET['dev']));
    $devFlagFile  = __DIR__ . "/data/users/test-user.json";
    $devFlagTemplate = __DIR__ . '/test-user.template';
// kontrola souboru – pokud existuje a je starší než 10 min → obnov z template
if (IS_DEV && file_exists($devFlagTemplate)) {
    if (!file_exists($devFlagFile) || (time() - filemtime($devFlagFile) > 600)) {
        copy($devFlagTemplate, $devFlagFile); // překopíruje se dle vzoru -> nový timestamp
    }
}

    if (isset($_SESSION['user'])) {
        $googleId = $_SESSION['user']['id'] ?? null;
        $settingsFile = __DIR__ . "/data/users/{$googleId}.json";

        if ($googleId && file_exists($settingsFile)) {
        $settingsJson = file_get_contents($settingsFile);
        $settings = json_decode($settingsJson, true);
        } else {
            $settings = [
                'wallpaper' => 'sanabi-wallpaper.jpg',
                'wallpaper_position' => 'center',
                'bookmarks' => [],
                'rss' => [],
            ];
        }
        $_SESSION['settings'] = $settings;
        $wallpaper = htmlspecialchars($settings['wallpaper']);
        $wallpaperPosition = htmlspecialchars($settings['wallpaper_position']);

    } else { 
        include '../logger.php';
        $wallpaper = "sanabi-wallpaper.jpg";
        $wallpaperPosition = "center";
    }
        echo "<style>";
        echo ".background-overlay {";
        echo "background: url('img/" . $wallpaper . "') no-repeat " . $wallpaperPosition . "/cover;";
        echo "} </style>";
    
    if (isset($_GET['rss'])) {
        // 'rss'
        $feedUrls = $settings['rss'] ?? [];

        $items = [];

        foreach ($feedUrls as $url) {
            $xml = @simplexml_load_file($url);
            if (!$xml) continue;

            foreach ($xml->channel->item as $entry) {
                $title = (string) $entry->title;
                $link = (string) $entry->link;
                $description = (string) $entry->description;
                $pubDate = strtotime((string) $entry->pubDate);
                $image = '';

                if (isset($entry->enclosure)) {
                    $image = (string) $entry->enclosure['url'];
                }

                $items[] = [
                    'title' => $title,
                    'link' => $link,
                    'description' => $description,
                    'pubDate' => $pubDate,
                    'image' => $image
                ];

            }
        }

        // Seřazení sestupně podle data
        usort($items, function ($a, $b) {
        return $b['pubDate'] - $a['pubDate'];
        }); ?>
    <div class="background-overlay"></div>
    <?php
        echo "<img src='../logo/dnx-logo_mini_120px.png' 
        style='
            opacity: 0.6;
            position: absolute;
            top: 200px;
            left: 50%;
            transform: translate(-50%, -50%);
        ' 
        alt='Logo'>";
        echo '<div class="rss-feed" style="position: absolute; top: 400px; margin: 0px 20%">';
        foreach ($items as $article) {
            $title = htmlspecialchars($article['title']);
            $link = htmlspecialchars($article['link']);
            $image = htmlspecialchars($article['image']); // např. enclosure nebo default obrázek

            $date = new DateTime("@{$article['pubDate']}"); // "@" říká, že jde o timestamp
            $date->setTimezone(new DateTimeZone('Europe/Prague')); // časové pásmo

            echo "<div class='article'>
                    <img src='{$image}' alt='náhled' class='article-image'>
                    <a href='{$link}' target='_blank' class='article-title'>{$title}</a>" . 
                    $date->format('j. n. Y') . 
                  "</div>";
            
        }
        echo '</div>';

    } 
    elseif (isset($_GET['set'])) {
      // 'settings'
      ?>
    <div style="position: absolute; z-index: 5; top: 20px; right: 20px; display: flex; align-items: center">

        <?php if (isset($_SESSION['user'])): ?>
        <img src="<?= htmlspecialchars($_SESSION['user']['picture']) ?>" width="40" style="border-radius:50%">
        <strong style="margin-left: 12px"><?= htmlspecialchars($_SESSION['user']['name']) ?></strong> <?php
            else: ?>
        <a href="account/login.php" class="href-btn">
            <?= IS_DEV ? 'Přihlásit se (test)' : 'Přihlásit se přes Google' ?>
        </a>
        <?php
            endif;
        ?>
    </div>


    <div class="background-overlay"></div>
    <div class="background-overlay-color"></div>
    <style>
    .background-overlay-color {
        background: rgba(0, 0, 0, 0.40) !important;
        top: 0px;
        left: 0px;
        right: 0px;
        bottom: 0px;
        position: fixed;
        z-index: 1;
    }
    </style>

    <div style="position: absolute; z-index: 5; top: 150px; margin: 0 100px">

        <h2>Profil</h2>
        <?php if (!isset($_SESSION['user'])): ?>
        <a href="account/login.php" class="href-btn">
            <?= IS_DEV ? 'Přihlásit se (test)' : 'Přihlásit se přes Google' ?>
        </a>
        <?php else: ?>
        <div style="display: flex; align-items: center;">
            <p>Přihlášen jako <strong><?= htmlspecialchars($_SESSION['user']['name']) ?></strong></p>
            <a href="account/logout.php" class="href-btn" style="margin-left: auto;">Odhlásit se</a>
        </div>
        <?php endif; ?>

        <?php
            if (!isset($_SESSION['user'])) {
            echo '<p>Pro úpravu nastavení se prosím <a href="account/login.php" class="href-btn">přihlaš</a>.</p>';
            echo '<p>A nebo si aplikaci můžeš i jen vyzkoušet pro <a href="account/login.php?dev" class="href-btn">testovací účely</a>.</p>';
            exit;
        }
        // Načtení nastavení uživatele
        $googleId = $_SESSION['user']['id'] ?? null;
        $settingsFile = __DIR__ . "/data/users/{$googleId}.json";

        if ($googleId && file_exists($settingsFile)) {
            $settingsJson = file_get_contents($settingsFile);
            $settings = json_decode($settingsJson, true);
        }

        $_SESSION['settings'] = $settings;

        $wallpaperDir = __DIR__ . '/img/';
        $wallpapers = glob($wallpaperDir . '*.jpg');
        $selectedTheme = $settings['wallpaper'] ?? 'tokyo-city-wallpaper.jpg';
        $bookmarks = $settings['bookmarks'] ?? [];
        $rssFeeds = $settings['rss'] ?? [];
        ?>

        <form method="post" action="account/save-settings.php">
            <h2>Tapety</h2>
            <p class="form-description">Vyberte pozadí domovské obrazovky.</p>
            <div class="wallpaper-selection">
                <?php foreach ($wallpapers as $file):
            $filename = basename($file);
            $selectedClass = ($filename === $selectedTheme) ? 'checked' : '';
        ?>
                <div class="wallpaper-thumb">
                    <input type="radio" id="wp-<?= htmlspecialchars($filename) ?>" name="wallpaper"
                        value="<?= htmlspecialchars($filename) ?>" <?= $selectedClass ?> hidden>
                    <label for="wp-<?= htmlspecialchars($filename) ?>">
                        <img src="img/<?= htmlspecialchars($filename) ?>"
                            alt="Tapeta <?= htmlspecialchars($filename) ?>" width="100"
                            style="cursor:pointer; border:2px solid transparent; border-radius:8px;">
                    </label>
                </div>
                <?php endforeach; ?>
            </div>
            <h2>Pozice tapety</h2>
            <p class="form-description">
                Určuje, která část obrázku bude vycentrovaná. Např. „Na střed“ zobrazí střed tapety.
            </p>
            <select name="wallpaper_position" id="wallpaperPosition">
                <?php
                $positions = [
                    'center center' => 'Na střed',
                    'left center' => 'Vlevo',
                    'right center' => 'Vpravo'
                ];
                $selectedPosition = $settings['wallpaper_position'] ?? 'center center';
                foreach ($positions as $value => $label): ?>
                <option value="<?= $value ?>" <?= $selectedPosition === $value ? 'selected' : '' ?>>
                    <?= $label ?>
                </option>
                <?php endforeach; ?>
            </select>

            <h2>Vyhledávač</h2>
            <p class="form-description">
                Určuje, který vyhledávač se použije při zadání dotazu do vyhledávacího pole.
            </p>
            <select name="search_engine" required>
                <?php
                $engines = [
                    'google' => 'Google',
                    'duckduckgo' => 'DuckDuckGo',
                    'bing' => 'Bing',
                    'seznam' => 'Seznam',
                    'brave' => 'Brave'
                ];
                $selectedEngine = $settings['search_engine'] ?? 'google';
                foreach ($engines as $value => $label): ?>
                    <option value="<?= $value ?>" <?= $selectedEngine === $value ? 'selected' : '' ?>>
                        <?= $label ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <h2>Záložky</h2>
            <p class="form-description">
                Záložky slouží k rychlému přístupu k oblíbeným webům. Zobrazují se pod vyhledávačem na hlavní stránce.
            </p>

            <div id="bookmarks-container">
                <?php
        $categories = [
            'sluzby' => 'Služby',
            'zpravy' => 'Zprávy',
            'technologie' => 'Tech',
            'geek' => 'Geek',
            'uceni' => 'Učení'
        ];

        if (empty($bookmarks)) {
            $bookmarks = [['title' => '', 'url' => '', 'category' => '']];
        }
        foreach ($bookmarks as $i => $bookmark): 
                $currentCategory = $bookmark['category'] ?? ''; ?>
                <div class="bookmark-item">
                    <input type="text" name="bookmarks[<?= $i ?>][title]" placeholder="Název záložky"
                        value="<?= htmlspecialchars($bookmark['title'] ?? '') ?>" required>
                    <input type="url" name="bookmarks[<?= $i ?>][url]" placeholder="URL"
                        value="<?= htmlspecialchars($bookmark['url'] ?? '') ?>" required>
                    <select name="bookmarks[<?= $i ?>][category]" id="category-template">
                        <option value="">Vše</option>
                        <?php foreach ($categories as $value => $label): ?>
                        <option value="<?= $value ?>" <?= $value === $currentCategory ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" class="remove-bookmark delete-btn">Smazat</button>
                </div>
                <?php endforeach; ?>
            </div>
            <button type="button" id="add-bookmark" class="add-btn">Přidat záložku</button>

            <h2>RSS (Zprávy)</h2>
            <p class="form-description">
                Seznam zdrojů zpráv, ze kterých se načítají články na hlavní stránku.
            </p>
            <div id="rss-container">
                <?php
        if (empty($rssFeeds)) {
            $rssFeeds = [''];
        }
        foreach ($rssFeeds as $i => $rss): ?>
                <div class="rss-item">
                    <input type="url" name="rss[<?= $i ?>]" placeholder="RSS URL" value="<?= htmlspecialchars($rss) ?>"
                        required>
                    <button type="button" class="remove-rss delete-btn">Smazat</button>
                </div>
                <?php endforeach; ?>
            </div>
            <button type="button" id="add-rss" class="add-btn">Přidat RSS</button>

            <div style="margin-top: 50px; margin-bottom: 150px">
                <button type="submit" class="save-btn">Uložit</button>
                <a href="?dash" class="href-btn" style="padding-left: 10px">Zpět na dashboard</a>
            </div>
        </form>

    </div>
    <?php

    } 
    else {
      // 'dashboard' - výchozí ?>
    <div class="background-overlay"></div>

    <main>
        <?php
            $engine = $_SESSION['settings']['search_engine'] ?? 'google';

            $searchUrls = [
                'google' => 'https://www.google.com/search?q=',
                'duckduckgo' => 'https://duckduckgo.com/?q=',
                'bing' => 'https://www.bing.com/search?q=',
                'seznam' => 'https://search.seznam.cz/?q=',
                'brave' => 'https://search.brave.com/search?q='
            ];

            $searchBase = $searchUrls[$engine] ?? $searchUrls['google'];

        ?>

        <!-- Vyhledávač -->
        <form id="searchForm" method="get" target="_parent" action="<?= htmlspecialchars($searchBase) ?>">
            <div class="search-section"
                style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                <div class="search-logo"
                    style="display: flex; justify-content: center; opacity: 0.5; align-items: center; width: 100%; margin-bottom: 4em">
                    <img src="../logo/dnx-logo_mini_120px.png" alt="Logo">
                </div>
                <div class="search-wrapper" style="width: 100%; display: flex; justify-content: center;">
                    <ul class="autocomplete-list"></ul>
                    <input type="text" class="search-input" name="q" placeholder="Hledat na webu..." autocomplete="off"
                        style="width: 100%; max-width: 570px;">
                </div>
            </div>
        </form>


        <!-- Filtry -->
        <div class="filter-bar">
            <button class="filter-btn active" data-filter="all">Vše</button>
            <button class="filter-btn" data-filter="sluzby">Služby</button>
            <button class="filter-btn" data-filter="zpravy">Zprávy</button>
            <button class="filter-btn" data-filter="technologie">Technologie</button>
            <button class="filter-btn" data-filter="geek">Geek</button>
            <button class="filter-btn" data-filter="uceni">Učení</button>
        </div>

        <!-- Záložky -->
        <section class="bookmarks">
            <?php if (!empty($settings['bookmarks'])): ?>
            <?php foreach ($settings['bookmarks'] as $bookmark): ?>
            <?php
                    // Bezpečné zpracování
                    $title = htmlspecialchars($bookmark['title'] ?? '');
                    $url = htmlspecialchars($bookmark['url'] ?? '#');
                    $category = htmlspecialchars($bookmark['category'] ?? '');
                    ?>
            <a href="<?= $url ?>" class="bookmark" data-category="<?= $category ?>"><?= $title ?></a>
            <?php endforeach; ?>
            <?php else: ?>
            <a href="https://youtube.com" class="bookmark" data-category="sluzby">YouTube</a>
            <a href="https://facebook.com" class="bookmark" data-category="sluzby">Facebook</a>
            <a href="https://irozhlas.cz" class="bookmark" data-category="zpravy">iRozhlas</a>
            <a href="https://www.respekt.cz" class="bookmark" data-category="zpravy">RESPEKT</a>
            <a href="https://www.reflex.cz" class="bookmark" data-category="zpravy">Reflex</a>
            <a href="https://www.disneyplus.com/cs-cz/home" class="bookmark" data-category="geek">Disney+</a>
            <p style="display: flex; flex-wrap: nowrap">Pro vlastní nastavení se musíte přihlásit.</p>
            <?php endif; ?>

        </section>
        <?php
    }
  ?>
    </main>

    <nav class="bottom-navbar">
        <a href="?dash" class="nav-icon <?php if (isset($_GET['dash'])) { echo "active"; } ?>" title="Dashboard">
            <img src="../logo/dnx-logo_mini.ico" alt="Logo">
        </a>
        <a href="?rss" class="nav-icon <?php if (isset($_GET['rss'])) { echo "active"; } ?>" title="RSS feed">📡</a>
        <a href="?set" class="nav-icon <?php if (isset($_GET['set'])) { echo "active"; } ?>" title="Settings">⚙️</a>
    </nav>

    <!-- Javascript pro dash -->
    <?php if (!(isset($_GET['rss']) || isset($_GET['set'])))
    { echo "<script src='js/filter-bookmark.js'></script>"; } ?>
    <script src="js/scroll-wallpaper.js"></script>
    <!-- Javascript - Obecné -->
    <script src="js/navbar-hide.js"></script>
    <script src="js/logo-animated.js"></script>
    <!-- Javascript pro nastavení -->
    <?php if (isset($_GET['set']))
    { echo '<script src="js/settings-add.js"></script>
            <script src="js/settings-wallpaper.js"></script>'; } ?>

</body>


</html>