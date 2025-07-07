<?php
session_start();

// Zničí všechny session proměnné
$_SESSION = [];

// Ukončí session (smaže i session cookie)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

// Přesměrování zpět na domovskou stránku
header("Location: ../index.php?set");
exit;
?>