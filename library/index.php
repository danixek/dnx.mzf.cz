<!DOCTYPE html>
<html lang="cs">

<?php include '../partials/header.php'; ?>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-J4QB2029QQ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-J4QB2029QQ');
</script>

<body id="page-wrapper">
    <header>
        <?php
        // Navigační menu
        require('../partials/navbar.php');

        // Utilita v PHP na přepínání barev frontendu - CSS přepínač
        require('../utils.php');

        // Domů - nadpis, podnadpis a citáty
        require('../portfolio/partials/home.php'); ?>
    </header>
    <main>
        <!-- Sekce domů -->
        <section id="library" class="<?= getBgClass() ?> text-center text-white">
            Stránka se připravuje, brzy bude dostupná. <br>
            <p>Zde by měli být zajímavé odkazy a doporučení; ať už jde o odborná/zajímavá youtube videa či filmy/seriály a hry.</p>
            <a href="/" class="btn btn-themed mt-3">Zpět na domovskou stránku</a>
        </section>
    </main>

    <footer>
        <?php
        // Kontakt
        require('../partials/contacts.php'); ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/quotes.js"></script>
    <script src="/js/bs-tooltip.js"></script>

</body>

</html>