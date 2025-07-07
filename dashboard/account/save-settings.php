<?php
session_start();

// Získat uživatelské ID (Google nebo fake)
$userId = $_SESSION['user']['id'] ?? null;

if (!$userId) {
    http_response_code(403);
    exit('Not logged in');
}

$settingsFile = __DIR__ . "/../data/users/{$userId}.json";

// POST data - pro záložky a RSS předpokládám, že přijde JSON nebo pole
// Pokud pole, musíš ošetřit, že může být string (např. serialize JSON v inputu)
$updatedSettings = [
    'wallpaper' => $_POST['wallpaper'] ?? '05-wallpaper.jpg',
    'wallpaper_position' => $_POST['wallpaper_position'] ?? 'center center',
    'bookmarks' => $_POST['bookmarks'] ?? [], // třeba pole ['název' => 'odkaz', ...]
    'rss' => $_POST['rss'] ?? [],             // pole RSS url
    'search_engine' => $_POST['search_engine'] ?? 'google'
];


// Uložení do JSON
file_put_contents($settingsFile, json_encode($updatedSettings, JSON_PRETTY_PRINT));

if ($result === false) {
    http_response_code(500);
    exit('Chyba při ukládání souboru nastavení.');
}

// Přesměrování zpět
header('Location: ../index.php?set');
exit;
