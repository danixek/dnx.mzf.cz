<!DOCTYPE html>
<html lang="cs">

<?php include 'partials/header.php'; ?>

<body id="page-wrapper">
    <header>
        <?php
        // Navigační menu
        require('partials/navbar.php');

        // Utilita v PHP na přepínání barev frontendu - CSS přepínač
        require('utils.php');

        // Domů - nadpis, podnadpis a citáty
        require('portfolio/partials/home.php'); ?>
    </header>
    <main>
        <?php
        // O mně
        require('portfolio/partials/about.php');

        // Portfolio
        require('portfolio/partials/portfolio.php'); ?>
    </main>

    <footer>
        <?php
        // Kontakt
        require('partials/contacts.php'); ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/quotes.js"></script>
    <script src="js/bs-tooltip.js"></script>

</body>

</html>