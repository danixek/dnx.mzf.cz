<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/google.secret.php';
require_once __DIR__ . '/pdo.php';

// Set the client

session_start();

try {
    $client = new Google_Client();
    $client->setClientId($GOOGLE_CLIENT_ID);
    $client->setClientSecret($GOOGLE_CLIENT_SECRET);
    $client->setRedirectUri('https://dnx.mzf.cz/auth/google-callback.php');
    $client->addScope('email');
    $client->addScope('profile');

    if (!isset($_GET['code'])) {
        $_SESSION['login_error'] = 'Chybí autorizační kód.';
    }

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (isset($token['error'])) {
        $_SESSION['login_error'] = 'Chyba při získání tokenu.';
    }

    $client->setAccessToken($token);

    $oauth = new Google_Service_Oauth2($client);
    $userInfo = $oauth->userinfo->get();

    $googleId = $userInfo->id;
    $email = $userInfo->email ?? null;

    /**
     * LOGIN PŘES GOOGLE
     */
    if (!isset($_SESSION['user_id'])) {

        $stmt = pdo()->prepare("
        SELECT id, username, role
        FROM users
        WHERE google_id = :google_id
        LIMIT 1
    ");
        $stmt->execute([':google_id' => $googleId]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $_SESSION['login_error'] = 'Tento Google účet není propojen s žádným účtem.';
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['google_id'] = $googleId;
        print_r($userInfo);
        $_SESSION['avatar_url'] = $userInfo->picture ?? '/dashboard/img/default-avatar.png';

        header('Location: /dashboard.php');
        exit;
    } else {

        /**
         * Propojit Google účet s aktuálním uživatelem a uložit avatar
         */
        $stmt = pdo()->prepare("
        UPDATE users
        SET google_id = :google_id,
        avatar_url = :avatar_url
        WHERE id = :user_id
        AND (google_id IS NULL OR google_id = '')
    ");
        $stmt->execute([
            ':google_id' => $googleId,
            ':avatar_url' => $userInfo->picture,
            ':user_id' => $_SESSION['user_id']
        ]);

        // uložíme do session pro UI
        $_SESSION['google_id'] = $googleId;
        print_r($userInfo);
        $_SESSION['avatar_url'] = $userInfo->picture;

        // hotovo
        header('Location: /dashboard.php?set');
        exit;
    }
} catch (\Exception $e) {
    // vyčistit session
    session_unset();
    session_destroy();

    // volitelně logovat chybu
    error_log('Google login error: ' . $e->getMessage());

    $_SESSION['login_error'] = 'Došlo k chybě při přihlášení přes Google: ' . htmlspecialchars($e->getMessage());
}
?>