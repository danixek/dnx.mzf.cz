<!DOCTYPE html>
<html lang="cs">
<?php include '../logger.php'; ?>
<head>
    <link rel="canonical" href="https://dnx.mzf.cz">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="[ d] blog - O světě, kódu a myšlení. Ideální pro programátory s intelektuálním přesahem.">
    <meta property="og:description" content="[ d] blog - O světě, kódu a myšlení.">
    <meta name="author" content="danixek">
    <meta name="robots" content="index, follow">
    <title>[ d] blog</title>
</head>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H54YBDQYL1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H54YBDQYL1');
</script>

<style>
    .markdown-body {
        box-sizing: border-box;
        min-width: 200px;
        max-width: 980px;
        margin: 0 auto;
        padding: 45px;
    }

    @media (max-width: 767px) {
        .markdown-body {
            padding: 15px;
        }
    }
</style>

<body>

    <header>
        <?php

        define('BASE_URL', '..');

        // Navigační menu
        require('../partials/navbar.php');

        // Utilita v PHP na přepínání barev frontendu - CSS přepínač
        require('../utils.php'); ?>

        <!-- Sekce domů - speciální verze bez citátů -->
        <section id="home" class="<?= getBgClass() ?> text-center text-white pt-4">
            <div class="container mt-5 pt-4">
                <h1 class="display-2"><span style="position: relative; bottom: 4px">[</span> <span
                        style="font-size: 80%">d</span><span style="position: relative; bottom: 4px">]</span> blog</h1>
                <p class="lead pt-4">O světě, kódu a myšlení.</p>
            </div>
        </section>
    </header>
    <main>

        <!-- Sekce Blog - Výpis článků -->
        <?php if (!isset($_GET['post'])) { ?>
            <section id="blog" class="<?= getBgClass() ?> py-5 text-white">
                <div class="container">
                    <div class="row g-3">
                        <h2 class="section-title mb-0 me-3">Články</h2>

                        <?php
                        require 'lib/parsedown.php';
                        require 'lib/spyc.php';
                        $Parsedown = new Parsedown();

                        $files = glob(__DIR__ . "/posts/*.md");
                        if (empty($files)) {
                            echo "<p>Žádné články prozatím nebyly publikovány.</p>";
                        }

                        foreach ($files as $file) {
                            $filename = basename($file, ".md");
                            $content = file_get_contents($file);

                            // YAML parse
                            if (preg_match('/^---\s*(.*?)\s*---\s*(.*)$/s', $content, $matches)) {
                                $yaml = Spyc::YAMLLoadString($matches[1]);
                                $body = $matches[2];
                            } else {
                                $yaml = [];
                                $body = $content;
                            }

                            $title = $yaml['title'] ?? $filename;
                            $image = $yaml['image'] ?? "default-thumb.png";
                            $excerpt = mb_substr(strip_tags($Parsedown->text($body)), 0, 90);
                            ?>
                            <a href="?post=<?= urlencode($filename) ?>"
                                class="col-lg-3 col-md-4 col-sm-6 col-12 d-flex text-decoration-none">
                                <div class="card bg-dark text-light flex-fill">
                                    <div class="ratio ratio-16x9">
                                        <img src="posts/thumbs/<?= htmlspecialchars($image) ?>"
                                            alt="<?= mb_substr(htmlspecialchars($title), 0, 25) ?>..."
                                            class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover"
                                            style="font-size: 99%">
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title"><?= htmlspecialchars($title) ?></h5>
                                        <p class="card-text flex-grow-1"><?= htmlspecialchars($excerpt) ?>…</p>
                                        <span class="project-link mt-2 text-nowrap ms-auto">[Zobrazit více]</span>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                        <style>
                            .card {background-color: rgba(20,20,20,0.4) !important}
                        </style>
                    </div>
                </div>
            </section>
            <?php
        } else { ?>
            <!-- Sekce blog - Detail článku -->
            <section id="blog" class="<?= getBgClass() ?>text-white py-5">
                <?php
                require 'lib/parsedown.php';
                require 'lib/spyc.php';
                function parseMarkdownWithYaml($filePath)
                {
                    $content = file_get_contents($filePath);

                    if (preg_match('/^---\s*(.*?)\s*---\s*(.*)$/s', $content, $matches)) {
                        $yaml = $matches[1];
                        $markdown = $matches[2];
                        $meta = Spyc::YAMLLoadString($yaml);
                        return ['meta' => $meta, 'content' => $markdown];
                    } else {
                        return ['meta' => [], 'content' => $content];
                    }
                }

                $Parsedown = new Parsedown();

                $post = basename($_GET['post']);
                $path = __DIR__ . "/posts/$post.md";
                ?>
                <div class="container">
                    <div class="row text-left g-3">
                        <div class="col-md-7 col-sm-9 col-12 content-column">
                            <div class="ms-2">
                                <?php


                                if (file_exists($path)) {
                                    $data = parseMarkdownWithYaml($path);
                                    $title = $data['meta']['title'] ?? $post;
                                    $subtitle = $data['meta']['subtitle'] ?? $post;
                                    $image = $data['meta']['image'] ?? "default-thumb.png";
                                    $date = $data['meta']['date'] ?? null;
                                    $tags = $data['meta']['tags'] ?? [];

                                    echo "<h1>" . htmlspecialchars($title) . "</h1>";
                                    echo "<p style='font-size: 120%'>" . htmlspecialchars($subtitle) . "</p>";

                                    echo "<div class='ms-4'>";
                                    echo $Parsedown->text($data['content']);
                                    echo "</div>";
                                    echo "<p><a href='?'>Zpět na seznam článků</a></p>";
                                } else {
                                    echo "<h2>Článek nenalezen</h2>";
                                    echo "<p><a href='?'>Zpět na seznam článků</a></p>";
                                }

                                ?>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-3 col-12 image-column">
                            <div class="ratio ratio-16x9">
                                <img src="posts/thumbs/<?= htmlspecialchars($image) ?>" alt="<?php if (!empty($title)) {
                                      htmlspecialchars($title);
                                  } else {
                                      echo " ";
                                  } ?>"
                                    class="rounded-3 position-absolute top-0 start-0 w-100 h-100 object-fit-cover">
                            </div>
                            <style>
                                @media (max-width: 768px) {
                                    .image-column {
                                        display: none;
                                    }

                                    .content-column {
                                        width: 100% !important;
                                    }
                                }
                            </style>
                        </div>
                        <div class="col-12 content-column">
                            <div class="ms-2">
                                <?php

                                echo "<p style='font-size: 90%; padding-bottom: 5px; color: #ccc;'>";

                                if (!empty($date)) {
                                    echo "🗓️ " . htmlspecialchars($date);
                                }
                                if ($date)
                                    echo " &nbsp;|&nbsp; ";
                                echo "<span class='badge bg-secondary'>.markdown powered</span>";
                                if (!empty($tags)) {
                                    if ($tags && is_array($tags)) {
                                        echo " &nbsp;|&nbsp; ";
                                        echo "🏷️ ";
                                        $safeTags = array_map('htmlspecialchars', $tags);
                                        echo implode(", ", $safeTags);
                                    }
                                }

                                echo "</p>";

                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        } ?>


    </main>
    <footer>
        <?php
        // Citáty
        require('../partials/quotes.php');

        // Kontakt
        require('../partials/contacts.php'); ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/quotes.js"></script>
    <script src="../js/bs-tooltip.js"></script>


</body>

</html>