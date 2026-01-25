<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/google.secret.php';

session_start();

$client = new Google_Client();
$client->setClientId($GOOGLE_CLIENT_ID);
$client->setClientSecret($GOOGLE_CLIENT_SECRET);
$client->setRedirectUri('https://dnx.mzf.cz/auth/google-callback.php');
$client->addScope('email');
$client->addScope('profile');

$authUrl = $client->createAuthUrl();
header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
exit;
?>