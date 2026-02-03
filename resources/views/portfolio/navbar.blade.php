<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark"
    style="position: fixed; left: 0px; top: 0px; right: 0px; z-index: 99; opacity: 0.95; height: 60px">
    <div class="container">

        <a class="navbar-brand" href="/#" id="logo-link">
            <img src="logo/dnx-logo_mini_60px.png" alt="Logo" class="logo-img mb-1">
            <span class="logo-text">
                <l>D</l>aniel <b>Kefurt</b>
            </span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/#">Domů</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/#about">O mně</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/#portfolio">Portfolio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/#contact">Kontakt</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/blog.php">Blog</a>
                </li>
                <li class="nav-item">
                    <button id="theme-toggle" class="btn btn-outline-secondary btn-sm" data-bs-tooltip="tooltip"
                        data-bs-placement="bottom" title="Změnit vzhled stránky" style="border-color: transparent">
                        <i class="bi bi-circle-half"></i>
                    </button>
                </li>
                <li class="nav-item">
                    <!-- Button trigger modal -->
                    <?php
                    session_start();
                    if (isset($_SESSION['user_id'])): ?>
                        <span class="nav-link d-flex align-items-center gap-2" style="margin-left: 12px;"> <?php
                            if (isset($_SESSION['user_id'])): ?>
                                <img src="<?php echo htmlspecialchars($_SESSION['avatar_url'] ?? '/dashboard/default_avatar.png'); ?>"
                                    style="width: 35px; border-radius:50%">
                            <?php 
                            endif; ?>
                            <strong style="margin-left: 6px"><?= htmlspecialchars($_SESSION['username']) ?></strong>
                        </span>
                        <?php
                    else: ?>
                        <span class="nav-link" role="button" style="margin-left: 12px" data-bs-toggle="modal"
                            data-bs-target="#loginRegisterModal">
                            Přihlásit se
                        </span>
                        <?php
                    endif;
                    ?>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script src="js/theme-toggler.js"></script>