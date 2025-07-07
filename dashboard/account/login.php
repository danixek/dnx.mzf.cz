<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/google.secret.php';
define('IS_DEV', in_array($_SERVER['SERVER_NAME'], ['localhost', 'dnx.test']));
session_start();

if (defined('IS_DEV') && IS_DEV) {
    // Falešný uživatel
    $_SESSION['user'] = [
        'id' => '1234567890',
        'name' => 'Testovací Uživatel',
        'email' => 'test@example.com',
        'picture' => 'default_avatar.jpg' // náhradní avatar
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
} else {
    $client = new Google_Client();
    $client->setClientId($GOOGLE_CLIENT_ID);
    $client->setClientSecret($GOOGLE_CLIENT_SECRET);
    $client->setRedirectUri('https://dnx.mzf.cz/dashboard/google-callback.php');
    $client->addScope('email');
    $client->addScope('profile');



    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
    exit;
}