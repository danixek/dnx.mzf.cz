<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark"
    style="position: fixed; left: 0px; top: 0px; right: 0px; z-index: 99; opacity: 0.95; height: 60px">
    <div class="container">

        <a class="navbar-brand" href="index.php#" id="logo-link">
            <img src="logo/dnx-logo_mini_60px.png" alt="Logo" class="logo-img">
            <span class="logo-text">
                <l>D</l>aniel <b>Kefurt</b>
            </span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php#">Domů</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php#about">O mně</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php#portfolio">Portfolio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php#contact">Kontakt</a>
                </li>
                <li class="nav-item mt-1">
                    <button id="theme-toggle" class="btn btn-outline-secondary btn-sm" data-bs-tooltip="tooltip"
                        data-bs-placement="bottom" title="Změnit vzhled stránky" style="border-color: transparent">
                        <i class="bi bi-circle-half"></i>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script src="portfolio/js/theme-toggler.js"></script>