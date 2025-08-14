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
// řádek do logu
$logLine = "[$date] - $userLocation - IP: $ip - UA: $ua" . PHP_EOL;

// přidání do souboru
file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);
?>