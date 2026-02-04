<!-- Sekce O mně -->
<section id="about" class="{{ $bgClass }} main">
    <div class="container align-items-center">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="section-title mb-0">O mně</h2>
            <a class="btn-link p-0 collapse-link" data-bs-toggle="collapse" href="#collapseAbout" role="button"
                aria-expanded="false" aria-controls="collapseContent">
                [Zobrazit více]
            </a>
        </div>
        <div class="row align-items-center">

            <!-- Text -->
            <div class="col-lg-8 col-md-8 order-1 order-md-1">
                <h3 class="fs-5 fw-bold">Technologie, které mě oslovují</h3>
                <p class="section-content">Nejblíže mám k <strong>C#</strong> technologiím, zejména k <strong>ASP.NET</strong>. 
                    Postupně se učím i <strong>WPF</strong>, které mě oslovilo pro vývoj desktopových aplikací. Zároveň mám blízko k <strong>Linuxu</strong>,
                    návrhu <strong>API</strong>, ale i <strong>bezpečnosti</strong> - vidím tam velký potenciál pro
                    další rozvoj.
                    Sleduji vývoj technologií i potřeb uživatelů – chci růst v kreativního, praktického
                    vývojáře s přesahem.
                    <br><br>
                    Vlastními projekty jsem se naučil navrhovat databázové modely, pracovat s UI v <strong>Bootstrapu</strong> a
                    vytvářet moderní responzivní weby – ať už v <strong>JavaScriptu</strong>, <strong>PHP</strong>, nebo s
                    hotového UI frameworku.
                </p>

            </div>

            <!-- Obrázek -->
            <div class="col-lg-4 col-md-4 order-2 order-md-2 text-center text-md-end">
                <img src="{{ asset('assets/portfolio/img/profile.jpg') }}" alt="O mně"
                    class="img-fluid rounded shadow mx-auto d-block d-md-inline" style="max-width: 100%; height: auto">
            </div>

            <!-- Collapse obsah -->
            <div class="collapse order-3" id="collapseAbout">
                <h3 class="sub-section-title fs-5 fw-bold mt-1">Moje cesta k programování</h3>
                <p class="section-content">Už od dětství mě programování přitahovalo – svoboda tvořit vlastní logiku a
                    stavět malé digitální světy.
                    Později jsem zjistil, jak spojit radost z tvorby s reálným dopadem, ať už pro firmy, v podnikání,
                    pro ostatní, nebo v
                    každodenním životě.
                </p>
                <!--
                <div class="text-end">
                    <a href="/blog/" class="btn-link collapse-link">[Zobrazit článek]</a>
                </div>
                -->
                <h3 class="sub-section-title fs-5 fw-bold">Růstové myšlení místo rutiny</h3>
                <p class="section-content">Nebojím se jít proti proudu, když to vede k lepšímu řešení. Na střední škole
                    jsem se soustředil na budování růstového myšlení – učil jsem se přijímat výzvy, zkoušet nové cesty a
                    učit se z vlastních chyb. Přestože jsem původně studoval netechnický obor, zájem o programování mě
                    provázel už tehdy a nakonec jsem se rozhodl pro rekvalifikaci, která mi umožnila naplno se ponořit
                    do světa vývoje.
                </p>
                <!--
                <div class="text-end">
                    <a href="/blog/" class="btn-link collapse-link">[Zobrazit článek]</a>
                </div>
                -->

                <div class="row">
                    <div class="col-md-4 col-12 order-1 text-center">
                        <img src="{{ asset('assets/portfolio/img/library.jpg') }}" class="img-fluid m-0 me-1 mt-4" loading="lazy" />
                        <a href="{!! route('library') !!}" class="d-inline-block mt-2 collapse-link btn-link">[Knihovna - Easter
                            egg]</a>
                    </div>
                    <div class="col-12 col-md-8 order-2">
                        <h3 class="sub-section-title fs-5 fw-bold">Co hledám v práci</h3>
                        <p class="section-content">
                            Chci týmově spolupracovat, argumentovat a sdílet nápady. Věřím, že vývoj je o komunikaci
                            stejně
                            jako
                            o kódu. Hledám prostředí, kde se technické výzvy potkávají s růstem – jak profesně, tak i v
                            osobním
                            životě.
                        </p>
                        <!--
                    <div class="text-end">
                        <a href="/blog/" class="btn-link collapse-link">[Zobrazit článek]</a>
                    </div>
                    -->
                        <h3 class="sub-section-title fs-5 fw-bold">Kde chci ideálně působit?</h3>
                        <p class="section-content" style="margin-bottom: 10px">
                            Věřím, že kvalitní kód nestačí: klíčová je empatie, komunikace, <strong>schopnost
                                debatovat</strong> i hledat nové cesty k cíli.
                            Rád bych působil v okolí Prahy – v místě, které nabízí nejen technické výzvy, ale i živou
                            odbornou a
                            komunitní scénu.
                        </p>
                        <!--
                    <div class="text-end">
                        <a href="/blog/" class="btn-link collapse-link">[Zobrazit článek]</a>
                    </div>
                    -->
                    </div>
                </div>

            </div>
            <div class="mt-4 order-4 row d-flex align-items-center" style="padding-right: 0px;">
                <!-- Odkaz na Blog (zobrazit více) -->
                <div class="justify-content-start me-auto mt-1 col-6 d-flex align-items-center">
                    <!--
                    <a href="/blog">
                        [ <i class="bi bi-journal-text me-2"></i>Zobrazit blog ]
                    </a>
                    -->
                </div>
                <!-- Životopis ke stažení a zobrazení -->
                <div class="justify-content-end ms-auto col-6 text-end d-flex align-items-center">
                    <div class="btn-group">
                        <a href="CV_Csharp_Daniel-Kefurt.pdf" download
                            class="btn btn-themed d-flex align-items-center">
                            <i class="bi bi-download me-2"></i> Stáhnout životopis
                        </a>
                        <button type="button" class="btn btn-themed dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true"
                            aria-label="Další akce">
                            <span class="visually-hidden">Další akce</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark bg-dark">
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="CV_Csharp_Daniel-Kefurt.pdf" target="_blank"
                                    rel="noopener noreferrer">
                                    <i class="bi bi-file-earmark-pdf me-2"></i> Zobrazit životopis
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="CL_Csharp_Daniel-Kefurt.pdf" download>
                                    <i class="bi bi-download me-2"></i> Stáhnout průvodní dopis
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="CL_Csharp_Daniel-Kefurt.pdf" target="_blank">
                                    <i class="bi bi-file-earmark-pdf me-2"></i> Zobrazit průvodní dopis
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

</section>