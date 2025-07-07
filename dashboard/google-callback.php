<?php
session_start();
define('IS_DEV', in_array($_SERVER['SERVER_NAME'], ['localhost', 'dnx.test']));

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/account/google.secret.php';

// Nastav klienta
$client = new Google_Client();
$client->setClientId($GOOGLE_CLIENT_ID);
$client->setClientSecret($GOOGLE_CLIENT_SECRET);
$client->setRedirectUri('https://dnx.mzf.cz/dashboard/google-callback.php');
$client->addScope('email');
$client->addScope('profile');

if (defined('IS_DEV') && IS_DEV) {
    // Falešný uživatel
    $_SESSION['user'] = [
        'id' => '1234567890',
        'name' => 'Testovací Uživatel',
        'email' => 'test@example.com',
        'picture' => 'img/default_avatar.jpg' // náhradní avatar
    ];

    // Výchozí nastavení
    $_SESSION['settings'] = [
        'wallpaper' => '05-wallpaper.jpg',
        'wallpaper_position' => 'center center',
        'bookmarks' => [],
        'rss' => [],
        'search_engine' => 'google', // výchozí
    ];

    header('Location: index.php?set'); // přesměrování na hlavní stránku
    exit;
}   // Ověř, že přišel kód od Google
elseif (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);

        // Načti info o uživateli
        $oauth = new Google_Service_Oauth2($client);
        $userInfo = $oauth->userinfo->get();

        // Ulož ID
        $googleId = $userInfo->id;

        // Cesta k souboru
        $settingsDir = __DIR__ . "/data/users";
        if (!is_dir($settingsDir)) {
            mkdir($settingsDir, 0777, true);
        }
        $settingsFile = "$settingsDir/{$googleId}.json";

        // Výchozí nastavení, pokud neexistuje
        if (!file_exists($settingsFile)) {
            $defaultSettings = [
                'wallpaper' => '05-wallpaper.jpg',
                'bookmarks' => 'bookmarks' ?? [],
                'rss' => 'rss' ?? [],
            ];
            file_put_contents($settingsFile, json_encode($defaultSettings, JSON_PRETTY_PRINT));
        }

        // Načti nastavení a ulož do session
        $settings = json_decode(file_get_contents($settingsFile), true);
        $_SESSION['settings'] = $settings;
        $_SESSION['user'] = [
            'id' => $userInfo->id,
            'email' => $userInfo->email,
            'name' => $userInfo->name,
            'picture' => $userInfo->picture
        ];

        // Přesměruj na dashboard
        header('Location: index.php?set');
        exit;
    } else {
        echo "Chyba při získávání tokenu: " . htmlspecialchars($token['error']);
    }
} else {
    echo "Kód chybí v URL. Přihlášení selhalo.";
}
?>