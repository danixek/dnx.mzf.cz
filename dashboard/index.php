<!DOCTYPE html>
<html lang="cs" class="theme-dark">

<head>
  <meta charset="UTF-8" />
  <link rel="shortcut icon" href="../logo/dnx-logo_mini.ico" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <link rel="stylesheet" href="styles.css" />
</head>

<body>
  <div class="background-overlay"></div>

  <main>
    <a class="logo-wrapper" href="index.php">
      <img src="../logo/dnx-logo_mini_60px.png" alt="Logo">
      <span class="logo-text">
        <span class="visually-hidden">d</span>
        <span class="logo_text-show" id="logo-text">nx</span>
      </span>
    </a>


    <!-- Vyhledávač -->
    <form id="searchForm" method="get" target="_parent" action="https://search.brave.com/search">
      <div class="search-section">
        <div class="search-wrapper">
          <ul class="autocomplete-list"></ul>
          <input type="text" class="search-input" type="text" name="q" placeholder="Hledat na webu..."
            autocomplete="off">
        </div>
      </div>
    </form>


    <!-- Filtry -->
    <div class="filter-bar">
      <button class="filter-btn active" data-filter="all">Vše</button>
      <button class="filter-btn" data-filter="sluzby">Služby</button>
      <button class="filter-btn" data-filter="zpravy">Zprávy</button>
      <button class="filter-btn" data-filter="technologie">Technologie</button>
      <button class="filter-btn" data-filter="geek">Geek</button>
      <button class="filter-btn" data-filter="uceni">Učení</button>
      <button class="filter-btn" data-filter="personal">Osobní</button>
    </div>

    <!-- Záložky -->
    <section class="bookmarks">
      <!-- Služby (primárně nástroje, platformy, kde se něco dělá nebo spravuje) -->
      <a href="https://gmail.com" class="bookmark" data-category="sluzby">Gmail</a>
      <a href="https://youtube.com" class="bookmark" data-category="sluzby">YouTube</a>
      <a href="https://facebook.com" class="bookmark" data-category="sluzby">Facebook</a>
      <a href="https://discord.com/app" class="bookmark" data-category="sluzby">Discord</a>

      <!-- Technologie (čistě IT nástroje a zdroje pro programátory, vývojáře) -->
      <a href="https://stackoverflow.com" class="bookmark" data-category="technologie">Stack Overflow</a>
      <a href="https://github.com" class="bookmark" data-category="technologie">GitHub</a>

      <!-- Zprávy (informace, média, zpravodajství) -->
      <a href="https://ct24.ceskatelevize.cz" class="bookmark" data-category="zpravy">Česká televize</a>
      <a href="https://irozhlas.cz" class="bookmark" data-category="zpravy">iRozhlas</a>
      <a href="https://aktualne.cz" class="bookmark" data-category="zpravy">Aktuálně.cz</a>
      <a href="https://reflex.cz" class="bookmark" data-category="zpravy">Institut VK</a>
      <a href="https://piratskyinstitut.cz" class="bookmark" data-category="zpravy">Institut π</a>
      <a href="https://root.cz" class="bookmark" data-category="zpravy">root.cz</a>
      <a href="https://mandaty.cz" class="bookmark" data-category="zpravy">mandaty.cz</a>
      <a href="https://irozhlas.cz" class="bookmark" data-category="zpravy">irozhlas.cz</a>
      <a href="https://hn.cz" class="bookmark" data-category="zpravy">Hospodářské noviny</a>
      <a href="https://www.respekt.cz" class="bookmark" data-category="zpravy">RESPEKT</a>
      <a href="https://www.reflex.cz" class="bookmark" data-category="zpravy">Reflex</a>
      <a href="https://www.e15.cz" class="bookmark" data-category="zpravy">E15</a>
      <a href="https://www.info.cz" class="bookmark" data-category="zpravy">info.cz</a>
      <a href="https://echo24.cz" class="bookmark" data-category="zpravy">echo24</a>
      <a href="https://parlamentnilisty.cz" class="bookmark" data-category="zpravy">Parlamentní listy</a>

      <!-- Geek (fandom, seriály, IT i zábava) -->
      <a href="https://equestriadaily.cz" class="bookmark" data-category="geek">Equestria Daily</a>
      <a href="https://itnetwork.cz" class="bookmark" data-category="geek">ITnetwork</a>
      <a href="https://svetserialu.to" class="bookmark" data-category="geek">Svět Seriálů</a>
      <a href="https://www.soom.cz" class="bookmark" data-category="geek">Soom.cz</a>
      <a href="https://najserialy.to" class="bookmark" data-category="geek">NAJserialy.io</a>
      <a href="https://www.disneyplus.com/cs-cz/home" class="bookmark" data-category="geek">Disney+</a>
      <a href="https://www.crunchyroll.com" class="bookmark" data-category="geek">CrunchyRoll</a>

      <!-- Učení (školení, studium, matika) -->
      <a href="https://isibalo.com/matematika" class="bookmark" data-category="uceni">Isibalo</a>
      <a href="https://jakserychlenaucit.cz" class="bookmark" data-category="uceni">Jak se rychle naučit</a>
      <a href="https://rubesz.cz" class="bookmark" data-category="uceni">Rubesz Sbírka</a>
      <a href="https://fit.cvut.cz/cs/uchazeci/prijimaci-rizeni/bakalarsky-studijni-program" class="bookmark" data-category="uceni">FIT ČVUT</a>
      <a href="https://www.matweb.cz" class="bookmark" data-category="uceni">Matweb.cz</a>
      <a href="https://michalheczko.cz/kombinatorika/index.php?p=kombinatorika" class="bookmark" data-category="uceni">Kombinatorika</a>
      <a href="https://www.realisticky.cz/ucebnice.php?id=4" class="bookmark" data-category="uceni">Realisticky</a>

      <!-- Osobní (záliby, organizace, seznamy) -->
      <a href="https://myanimelist.net" class="bookmark" data-category="personal">MyAnimeList</a>


      <!-- Další záložky -->

      <?php /*
      <a href="https://webadmin.endora.cz/user/filemanager/edit/dnx.mzf.cz/web?file=%2Fdnx.mzf.cz%2Fweb%2Fhomepage.php"
        data-tags="endora dnx" class="bookmark" data-category="personal">
        editace homepage.php
      </a>

      <a href="https://webadmin.endora.cz/user/filemanager/edit/dnx.mzf.cz/web?file=%2Fdnx.mzf.cz%2Fweb%2Fdesktop.php"
        data-tags="endora dnx" class="bookmark" data-category="personal">
        editace desktop.php
      </a>

      <a href="https://webadmin.endora.cz/user/filemanager/default/dnx.mzf.cz/web?file=%2Fdnx.mzf.cz%2Fweb%2Fhomepage.php"
        data-tags="endora dnx" class="bookmark" data-category="personal">
        Správa dnx.mzf.cz</a>

      <a href="https://eshop.scio.cz/Profil/OPBH/Online_Priprava_VS" data-tags="matika matematika přijímačky"
        class="bookmark" data-category="uceni">
        SCIO testy na VŠ</a>

      <a href="https://moodle-ostatni.cvut.cz/course/view.php?id=134" data-tags="matika matematika přijímačky"
        class="bookmark" data-category="uceni">
        ČVUT moodle</a>

      <a href="http://www.realisticky.cz/ucebnice.php?id=4" data-tags="matika matematika učebnice" class="bookmark"
        data-category="uceni" style="font-size: 90%;">
        učebnice Realisticky</a>

      <a href="https://www.deepl.com/cs/translator" data-tags="překladač translate" class="bookmark"
        data-category="uceni">
        DeepL</a>

      <a href="https://englishfile4e.oxfordonlinepractice.com/app/dashboard"
        data-tags="angličtina oxford minidiv english" class="bookmark" data-category="uceni">
        Eng File</a>

      <a href="https://slovniky.lingea.cz/anglicko-cesky/" data-tags="angličtina" class="bookmark"
        data-category="uceni">
        slovník</a>

      <a href="http://www.english-practice.at/" data-tags="angličtina" class="bookmark" data-category="uceni">
        english-practice.at</a>

      <a href="https://www.english-grammar.at/online_exercises/tenses/tenses_index.htm" data-tags="angličtina english"
        class="bookmark" data-category="uceni">
        eng grammar</a>

      <a href="https://www.engblocks.com/grammar/exercises/#google_vignette" data-tags="angličtina english"
        class="bookmark" data-category="uceni">
        EngBlocks</a>

      <a href="https://chat.openai.com" data-tags="AI umělá inteligence" class="bookmark" data-category="technologie">
        ChatGPT</a>

      <a href="https://gemini.google.com" data-tags="AI umělá inteligence" class="bookmark" data-category="technologie">
        Gemini</a>

      <a href="https://www.pirati.cz/" data-tags="liberální politická pirátská strana" class="bookmark"
        data-category="zpravy">
        Piráti</a>

      <a href="https://svobodni.cz/" data-tags="konzervativní libertariánská politická strana sso" class="bookmark"
        data-category="zpravy">
        Svobodní</a>

      <a href="https://yayponies.no/books/book.php?category=Friendship+is+Magic&amp;format=PDF"
        data-tags="mlp comics komiksy my little pony" class="bookmark" data-category="geek">
        MLP komiksy</a>
      <a href="https://www.obchod.crew.cz/kategorie-21646/komiks/crew-manga/" data-tags="crew comics komiksy anime"
        class="bookmark" data-category="geek">
        CREW komiksy</a>
      */ ?>


    </section>
  </main>

  <nav class="bottom-navbar">
    <a href="index.php" class="nav-icon active" title="Dashboard">
      <img src="../logo/dnx-logo_mini.ico" alt="Logo">
    </a>
    <a href="rss.php" class="nav-icon" title="RSS feed">📡</a>
    <a href="settings.php" class="nav-icon" title="Settings">⚙️</a>
  </nav>


  <script src="js/filter-bookmark.js"></script>
  <script src="js/scroll-wallpaper.js"></script>
  <script src="js/navbar-hide.js"></script>
  <script src="js/logo-animated.js"></script>

</body>

</html>