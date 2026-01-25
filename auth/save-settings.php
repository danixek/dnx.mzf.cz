<?php
session_start();
require 'pdo.php';

// Získat uživatelské ID
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    http_response_code(403);
    exit('Not logged in');
}

try {
    pdo()->beginTransaction();

    // --- dashboard_settings ---
    $dashboardId = $_POST['dashboard_id'] ?? null;

    if ($dashboardId) {
        // UPDATE existujícího záznamu
        $stmt = pdo()->prepare("
        UPDATE dashboard_settings
        SET wallpaper = :wallpaper,
            wallpaper_position = :wallpaper_position,
            search_engine = :search_engine
        WHERE id = :id
    ");
        $stmt->execute([
            ':wallpaper' => $_POST['wallpaper'],
            ':wallpaper_position' => $_POST['wallpaper_position'],
            ':search_engine' => $_POST['search_engine'],
            ':id' => $dashboardId
        ]);
    } else {
        // INSERT nového záznamu
        $stmt = pdo()->prepare("
        INSERT INTO dashboard_settings (user_id, wallpaper, wallpaper_position, search_engine)
        VALUES (:user_id, :wallpaper, :wallpaper_position, :search_engine)
    ");
        $stmt->execute([
            ':user_id' => $userId,
            ':wallpaper' => $_POST['wallpaper'],
            ':wallpaper_position' => $_POST['wallpaper_position'],
            ':search_engine' => $_POST['search_engine']
        ]);
    }

    // --- bookmarks ---
    $bookmarks = $_POST['bookmarks'] ?? [];

    foreach ($bookmarks as $b) {
        $bookmarkId = $b['id'] ?? null;

        if ($bookmarkId) {
            // UPDATE existující záložky
            $stmt = pdo()->prepare("
            UPDATE bookmarks
            SET title = :title, url = :url, category = :category
            WHERE id = :id AND user_id = :user_id
        ");
            $stmt->execute([
                ':title' => $b['title'] ?? '',
                ':url' => $b['url'] ?? '',
                ':category' => $b['category'] ?? '',
                ':id' => $bookmarkId,
                ':user_id' => $userId
            ]);
        } else {
            // INSERT nové záložky
            $stmt = pdo()->prepare("
            INSERT INTO bookmarks (user_id, title, url, category)
            VALUES (:user_id, :title, :url, :category)
        ");
            $stmt->execute([
                ':user_id' => $userId,
                ':title' => $b['title'] ?? '',
                ':url' => $b['url'] ?? '',
                ':category' => $b['category'] ?? '',
            ]);
        }
    }

    // --- rss_feeds ---
    $rssFeeds = $_POST['rss'] ?? [];

    foreach ($rssFeeds as $r) {
        $rssId = $r['id'] ?? null;

        if ($rssId) {
            // UPDATE existující RSS
            $stmt = pdo()->prepare("
            UPDATE rss_feeds
            SET feed_url = :feed_url
            WHERE id = :id AND user_id = :user_id
        ");
            $stmt->execute([
                ':feed_url' => $r['feed_url'] ?? '',
                ':id' => $rssId,
                ':user_id' => $userId
            ]);
        } else {
            // INSERT nové RSS
            $stmt = pdo()->prepare("
            INSERT INTO rss_feeds (user_id, feed_url)
            VALUES (:user_id, :feed_url)
        ");
            $stmt->execute([
                ':user_id' => $userId,
                ':feed_url' => $r['feed_url'] ?? '',
            ]);
        }
    }

    pdo()->commit();
    header('Location: ../dashboard?set');
    exit;

} catch (Exception $e) {
    pdo()->rollBack();
    http_response_code(500);
    exit('Chyba při ukládání do databáze: ' . $e->getMessage());
}