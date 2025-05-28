<!-- Sekce Kontakt -->
<section id="contact" class="<?= getBgClass() ?> footer">
    <div class="container">
        <h2 class="section-title">Kontakt</h2>

        <div class="row">
            <!-- Levá část pro email -->
            <div class="col-md-7 text-left">
                <p>Pokud se chcete spojit, neváhejte mi napsat na email:</p>
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

            </div>
            <!-- Pravá část pro GitHub -->
            <div class="col-md-5 text-right">
                <p>Nebo navštivte můj GitHub profil:</p>
                <p>
                    <a href="https://github.com/danixek" rel="noopener noreferrer" target="_blank"
                        class="github-link d-flex align-items-center">
                        <i class="bi bi-github" style="font-size: 35px; margin-right: 15px;"></i> <b>GitHub: danixek
                        </b>
                    </a>

                </p>
            </div>
        </div>
    </div>

    <div class="mt-5 pt-3 text-white">
        <p class="contacts-text mb-0 text-center d-flex justify-content-center align-items-center gap-2 flex-wrap">
            Made with <span class="contacts-heart" aria-label="love" style="color: #e25555;">♥</span> by
            <img src="/logo/dnx-logo_mini.ico" style="height: 20px; margin-bottom: 2px" />
            <span class="visually-hidden">D</span><span class="contacts-name">aniel Kefurt &copy;
                <?= date('Y') ?></span>
        </p>

    </div>


</section>