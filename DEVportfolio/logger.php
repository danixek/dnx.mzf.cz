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

if (basename($_SERVER['PHP_SELF']) === "detail.php" && isset($_GET['id']) && htmlspecialchars($project['title']) !== "") {
    // řádek do logu, i s názvem projektu
    $logLine = "[$date] - " . htmlspecialchars($project['title']) . "$userLocation - IP: $ip - UA: $ua" . PHP_EOL;
} else {
    // řádek do logu - univerzální
    $logLine = "[$date] - $userLocation - IP: $ip - UA: $ua" . PHP_EOL;
}

$blockedIps = [
    "2001:1ae9:15e:bc00:a437:bf78:53d5:d7eb",
    "2001:1ae9:15e:bc00:34b2:24c1:bda8:b9a9",
    "2001:1aef:183:46a7:0:4e:530f:c701",
    "193.86.230.167",
    "194.212.160.90"
];

if (!in_array($ip, $blockedIps, true)) {

    // přidání do souboru
    file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);

}

?>