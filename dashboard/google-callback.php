<?php
session_start();
define('IS_DEV', in_array($_SERVER['SERVER_NAME'], ['localhost', 'dnx.test']));

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/account/google.secret.php';

// Set the client
$client = new Google_Client();
$client->setClientId($GOOGLE_CLIENT_ID);
$client->setClientSecret($GOOGLE_CLIENT_SECRET);
$client->setRedirectUri('https://dnx.mzf.cz/dashboard/google-callback.php');
$client->addScope('email');
$client->addScope('profile');

if (defined('IS_DEV') && IS_DEV) {
    // Fake user
    $_SESSION['user'] = [
        'id' => '1234567890',
        'name' => 'Testovací Uživatel',
        'email' => 'test@example.com',
        'picture' => 'img/default_avatar.jpg' // replacement avatar
    ];

    // Default settings
    $_SESSION['settings'] = [
        'wallpaper' => '05-wallpaper.jpg',
        'wallpaper_position' => 'center center',
        'bookmarks' => [],
        'rss' => [],
        'search_engine' => 'google', // default
    ];

    header('Location: index.php?set'); // redirect to main page
    exit;
}   // Verification, if Google sent the code
elseif (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);

        // It loads info about user
        $oauth = new Google_Service_Oauth2($client);
        $userInfo = $oauth->userinfo->get();

        // It saves the ID
        $googleId = $userInfo->id;

        // Path to file
        $settingsDir = __DIR__ . "/data/users";
        if (!is_dir($settingsDir)) {
            mkdir($settingsDir, 0777, true);
        }
        $settingsFile = "$settingsDir/{$googleId}.json";

        // Default settings - if doesn't exist
        if (!file_exists($settingsFile)) {
            $defaultSettings = [
                'wallpaper' => '05-wallpaper.jpg',
                'bookmarks' => 'bookmarks' ?? [],
                'rss' => 'rss' ?? [],
            ];
            file_put_contents($settingsFile, json_encode($defaultSettings, JSON_PRETTY_PRINT));
        }

        // It loads settings and save into session
        $settings = json_decode(file_get_contents($settingsFile), true);
        $_SESSION['settings'] = $settings;
        $_SESSION['user'] = [
            'id' => $userInfo->id,
            'email' => $userInfo->email,
            'name' => $userInfo->name,
            'picture' => $userInfo->picture
        ];

        // Redirect to dashboard
        header('Location: index.php?set');
        exit;
    } else {
        echo "Error with getting token: " . htmlspecialchars($token['error']);
    }
} else {
    echo "The code is missed in URL. Login is unsuccesful.";
}
?>