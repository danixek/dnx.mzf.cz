<!DOCTYPE html>
<html lang="cs">

<?php include 'DEVportfolio/partials/header.php'; ?>
<?php include 'DEVportfolio/logger.php'; ?>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-JLWMMCFJX5"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-JLWMMCFJX5');
</script>

<body id="page-wrapper">
    <header>
        <?php
        // Navigační menu
        require('DEVportfolio/partials/navbar.php');

        // Utilita v PHP na přepínání barev frontendu - CSS přepínač
        require('DEVportfolio/utils.php');

        // Domů - nadpis, podnadpis a citáty
        require('DEVportfolio/partials/home.php'); ?>
    </header>
    <main>
        <?php
        // O mně
        require('DEVportfolio/partials/about.php');

        // Portfolio
        require('DEVportfolio/partials/portfolio.php');

        // Blog
        require('DEVportfolio/partials/blog.php'); ?>
    </main>

    <footer>
        <?php
        // Kontakt
        require('DEVportfolio/partials/contacts.php');
        require('DEVportfolio/partials/modals.php'); ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/DEVportfolio/js/quotes.js"></script>
    <script src="/DEVportfolio/js/bs-tooltip.js"></script>

</body>

</html>