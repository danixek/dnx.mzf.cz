            <section id="blog" class="<?= getBgClass('bg-light-gray') ?> py-5 text-white">
                <div class="container">
                    <div class="row g-3">
                        <h2 class="section-title mb-0 me-3">Články</h2>

                        <?php
                        require 'blog/lib/parsedown.php';
                        require 'blog/lib/spyc.php';
                        $Parsedown = new Parsedown();

                        $files = glob(__DIR__ . "/../../blog/posts/*.md");
                        // whitelist názvů souborů, které chceš "pinned"
                        $whitelist = [
                            'mbti_v_podnikani_a_hr.md',
                            'linux-budoucnost_her_a_iphonu.md',
                            'proc_firmy_ztraci_kdyz_lpi_na_juniorech.md'
                        ];

                        // vybrat jen soubory, které jsou ve whitelistu
                        $pinnedFiles = array_filter($files, function($file) use ($whitelist) {
                            return in_array(basename($file), $whitelist);
                        });

                        foreach ($pinnedFiles as $file) {
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
                            ?>
                            <a href="/blog/?post=<?= urlencode($filename) ?>" target="_blank"
                                class="col-lg-3 col-md-4 col-sm-6 col-12 d-flex text-decoration-none">
                                <div class="card bg-dark text-light flex-fill">
                                    <div class="ratio ratio-16x9">
                                        <img src="/blog/posts/thumbs/<?= htmlspecialchars($image) ?>"
                                            alt="<?= mb_substr(htmlspecialchars($title), 0, 25) ?>..."
                                            class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover"
                                            style="font-size: 99%">
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title"><?= htmlspecialchars($title) ?></h5>
                                        <span class="project-link mt-2 text-nowrap ms-auto mt-auto">[Zobrazit více]</span>
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