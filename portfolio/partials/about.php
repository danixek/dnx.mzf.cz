<!-- Sekce O mně -->
<section id="about" class="<?= getBgClass() ?> main">
    <div class="container align-items-center">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="section-title mb-0">O mně</h2>
            <a class="btn btn-link p-0 collapse-link" data-bs-toggle="collapse" href="#collapseAbout" role="button"
                aria-expanded="false" aria-controls="collapseContent">
                [Zobrazit více]
            </a>
        </div>
        <div class="row align-items-center">

            <!-- Text -->
            <div class="col-lg-8 col-md-8 order-1 order-md-1">
                <p class="section-content">Programování mě fascinuje od dětství – líbila se mi svoboda tvořit, zkoumat
                    a budovat vlastní malé světy.
                    Pro mě smysluplnost znamená spojit radost z tvorby s reálným dopadem, ať už v byznysu nebo jinde.
                    Časem jsem zjistil, že potencionální uspokojení vidím v navrhování řešení, která pomáhají nejen mně,
                    ale i ostatním, a skutečně zlepšují jejich každodenní zkušenosti.
                </p>
                <p class="section-content">Během střední školy jsem se místo intenzivního tréninku
                    programování soustředil hlavně na budování růstového myšlení –
                    učil jsem se přijímat výzvy, zkoušet nové cesty a učit se z vlastních chyb. Díky
                    tomu mám dnes pevný základ
                    pro rychlé osvojení nových technologií a neostýchám se hledat netradiční řešení.
                    I když jsem původně studoval netechnický obor, vždy jsem měl zájem o
                    programování. Nakonec jsem se rozhodl pro rekvalifikaci, která mi umožnila zaměřit se na technologie
                    a naplno se ponořit do světa vývoje.
                </p>
            </div>

            <!-- Obrázek -->
            <div class="col-lg-4 col-md-4 order-2 order-md-2 text-center text-md-end">
                <img src="profile.jpg" alt="O mně"
                    class="img-fluid rounded shadow mx-auto d-block d-md-inline" style="max-width: 100%; height: auto">
            </div>

            <!-- Collapse obsah -->
            <div class="collapse mt-5 order-3" id="collapseAbout">

                <p class="section-content">Chci se profilovat jako vývojář, který se soustředí na technologie jako
                    C# (ASP.NET, WPF) nebo JavaScript, ale nezastavím se u jedné technologie.
                    Neustálé učení nových nástrojů a sledování, jak se vyvíjejí technologie i potřeby uživatelů, mě
                    motivuje se stát se všestranným, kreativním a zároveň praktickým programátorem.
                </p>

                <p class="section-content">
                    Hledám pracovní prostředí, které mi umožní nejen profesní růst, ale i rozvoj sociálních dovedností –
                    debatování, týmovou spolupráci a aktivní společenský život. Okolí Prahy vnímám jako ideální místo,
                    kde mohu spojit technické výzvy s účastí na odborné a komunitní platformě - věřím totiž, že dobrý
                    kód sám o sobě nestačí; klíčová je empatie, komunikace a odvaha hledat lepší cesty k cíli.
                </p>


                <!-- Životopis ke stažení a zobrazení -->
                <div class="d-flex justify-content-end mt-3">
                    <div class="btn-group">
                        <a href="/portfolio/CV-danielKEFURT.pdf" download class="btn btn-outline-success d-flex align-items-center">
                            <i class="bi bi-download me-2"></i> Stáhnout životopis
                        </a>
                        <button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Další akce</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark bg-dark">
                            <li>
                                <a class="dropdown-item d-flex align-items-center me-4" href="/portfolio/CV-danielKEFURT.pdf"
                                    target="_blank">
                                    <i class="bi bi-file-earmark-pdf me-2"></i> Zobrazit životopis
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

</section>