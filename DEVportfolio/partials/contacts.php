<!-- Sekce Kontakt -->
<section id="contact" class="<?= getBgClass('') ?> footer">
    <div class="container">
        <h2 class="section-title">Kontakt</h2>

        <div class="row">
            <!-- Levá část pro email -->
            <div class="col-md-7 text-left">
                <p class="mb-4">Pokud se chcete spojit, neváhejte mi napsat na email:</p>
                <!-- Fallback pro uživatele bez JS -->
                <noscript>
                    <p>danielkefurt [V] gmail com</p>
                </noscript>


                <?php
                $email_name = 'danielkefurt';
                $email_domain = 'gmail.com';
                $encoded = base64_encode($email_name . '@' . $email_domain);
                ?>
                <!-- Placeholder pro JS -->
                <p id="e_m_l" aria-label="E-mailová adresa">[načítání e-mailu…]</p>

                <script>
                    const encoded = '<?= $encoded ?>';
                    const decoded = atob(encoded);
                    const link = `<a href="mailto:${decoded}">${decoded}</a>`;
                    document.getElementById("e_m_l").innerHTML = link;
                </script>

                <button id="bmc-button-dark" class="btn btn-themed my-4" aria-label="Buy me a coffee"
                    onclick="window.open('https://www.buymeacoffee.com/danixek', '_blank', 'noopener,noreferrer')">

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        style="width: 24px; height: 24px; margin-right: 10px;">
                        <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                        <path d="M2 8h16v9a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3V8z"></path>
                        <line x1="6" y1="1" x2="6" y2="4"></line>
                        <line x1="10" y1="1" x2="10" y2="4"></line>
                    </svg>

                    Buy me a coffee
                </button>



            </div>
            <!-- Pravá část pro GitHub a další odkazy -->
            <div class="col-md-5 text-right">
                <p>Nebo navštivte můj GitHub profil:</p>
                <p>
                    <a href="https://github.com/danixek" rel="noopener noreferrer" target="_blank"
                        class="contacts-links d-flex align-items-center">
                        <i class="bi bi-github" style="font-size: 35px; margin-right: 15px;"></i> <b>GitHub: danixek
                        </b>
                    </a>

                </p>
                <p class="gap-3 d-flex">
                    <a href="https://www.linkedin.com/in/d-kefurt/" rel="noopener noreferrer" target="_blank"
                        class="contacts-links">
                        <i class="bi bi-linkedin" style="font-size: 35px;"></i>
                    </a>
                    <a href="https://www.facebook.com/danixek" rel="noopener noreferrer" target="_blank"
                        class="contacts-links">
                        <i class="bi bi-facebook" style="font-size: 35px;"></i>
                    </a>

                </p>
            </div>
        </div>
    </div>

    <div class="mt-5 pt-3 text-white">
        <p class="contacts-text mb-0 text-center d-flex justify-content-center align-items-center gap-2 flex-wrap">
            Made with <span class="contacts-heart" aria-label="love" style="color: #e25555;">♥</span> by
            <img src="/DEVportfolio/logo/dnx-logo_mini.ico" style="height: 20px; margin-bottom: 2px" />
            <span class="visually-hidden">D</span><span class="contacts-name">aniel Kefurt &copy;
                <?= date('Y') ?></span>
        </p>

    </div>


</section>