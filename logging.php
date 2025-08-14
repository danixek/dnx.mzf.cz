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

if (basename($_SERVER['PHP_SELF']) === "detail.php" && isset($_GET['id']) && htmlspecialchars($selectedProject['title']) !== null) {
    // řádek do logu, i s názvem projektu
    $logLine = "[$date] - " . htmlspecialchars($selectedProject['title']) . "$userLocation - IP: $ip - UA: $ua" . PHP_EOL;
} else {
    // řádek do logu - univerzální
    $logLine = "[$date] - $userLocation - IP: $ip - UA: $ua" . PHP_EOL;
}

if ($ip !== "2001:1ae9:15e:bc00:a437:bf78:53d5:d7eb") {

    // přidání do souboru
    file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);

}

?>