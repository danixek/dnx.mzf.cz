<?php
function pdo(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        // absolutní cesta od webového kořene
        $envFile = $_SERVER['DOCUMENT_ROOT'] . '/auth/webuser.env';

        if (!file_exists($envFile)) {
            throw new RuntimeException("Soubor s přihlašovacími údaji nenalezen: $envFile");
        }

        $env = parse_ini_file($envFile);
        $pdo = new PDO(
            "mysql:host={$env['DB_HOST']};dbname={$env['DB_NAME']};charset=utf8mb4",
            $env['DB_USER'],
            $env['DB_PASS'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    return $pdo;
}
?>