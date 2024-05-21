<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="dnx_logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="pattern.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>dnx.cz</title>
    
</head>
<body>
<style>
        a {text-decoration: none;}
           
        <?php if ( /* isset($_GET['m'] */ none ) {
        $backgroundimageurl = "images/" . (isset($_GET['b']) ? $_GET['b'] : 'mlp1.png');
        echo ".main {background-image: url('" . $backgroundimageurl . "') !important; background-size: cover; background-repeat: no-repeat}";
        } else { echo ".main {background: rgb(50,50,50) !important}"; }
        ?>
        #searchForm {right: 0px; top: 0px; width: 32ch; position: absolute}
        .header_search {width: 28ch; z-index: 5; height: 40px; visibility: visible !important; border-bottom-left-radius: 15px; border-width: 0 0 2px 2px; border-style: solid; border-color: rgb(45,45,45);}

        #bookmarkList {
        list-style-type: none; padding: 0; margin: 0; position: relative; background-color: rgb(50,50,50);
        border: 1px solid rgb(80,80,80); z-index: 1000; left: 12px; width: 95%; top: 43px; color: white;
            border-bottom-left-radius: 10px; border-top-left-radius: 10px; display: none;
        }
        #bookmarkList li {height: 30px; padding-left: 20px; display: flex; align-items: center; transition: background-color 0.3s ease;}
        #bookmarkList li:hover {background-color: rgb(80,80,80)}
        #bookmarkList a:link, #bookmarkList a:visited {color: white}
        .table {visibility: visible; display: block}
        table-hidden {visibility: hidden; display: none}

        .jazykovka {margin-bottom: 7px; margin-right: 10px; background-color: rgb(40,40,40); border: solid 5px rgb(40,40,40); border-radius: 10px; height: 45px; width: 75px; color: white; text-align: center}
        .divs_jazykovka { margin-left: 30px; position: relative; z-index: 2; display: grid; flex-wrap: wrap;}
        .jazykovka-1st {display: flex; flex-wrap: wrap; order: 1}
        .jazykovka-2nd {display: flex; flex-wrap: wrap; order: 2}
        .jazykovka-3rd {display: flex; flex-wrap: wrap; order: 3}
        .divs_jazykovka .jazykovka-1st {margin-top: 10px;}
        .jazykovka-dark {background: #1c1c1c; border-color: #1c1c1c}
        .jazykovka-hide {display: none}
        </style>



<script>
// Funkce pro vyhledávání záložek v divu
function searchBookmarks() {
    const input = document.getElementById('searchInput');
    const keyword = input.value.toLowerCase();

    const tables = document.querySelectorAll('.table');
    const matchingBookmarks = [];

    tables.forEach(table => {
        const links = table.querySelectorAll('a');
        links.forEach(link => {
            const bookmarkText = link.textContent.toLowerCase();
            const bookmarkHref = link.href.toLowerCase();
            
            // Získání hodnoty data-tags atributu
            const dataTags = (table.dataset.tags ? table.dataset.tags.toLowerCase() + ' ' : '') +
                            (link.dataset.tags ? link.dataset.tags.toLowerCase() : '');


            // Kontrola, zda klíčová slova nebo tagy obsahují hledané slovo
            if (bookmarkText.includes(keyword) || bookmarkHref.includes(keyword) || dataTags.includes(keyword)) {
            matchingBookmarks.push({
                    text: bookmarkText,
                    href: bookmarkHref
                });
            }
        });
    });

    displayBookmarks(matchingBookmarks);
    
    function showBookmarks() {
    const input = document.getElementById('searchInput');
    const bookmarkList = document.getElementById('bookmarkList');

    bookmarkList.style.display = input.value.trim() !== '' ? 'block' : 'none';
}

document.getElementById('searchInput').addEventListener('input', showBookmarks);
}


// Funkce pro zobrazení nalezených záložek
function displayBookmarks(bookmarks) {
    const list = document.getElementById('bookmarkList');
    list.innerHTML = '';

    bookmarks.forEach(bookmark => {
        const listItem = document.createElement('li');
        const link = document.createElement('a');
        link.href = bookmark.href;
        link.textContent = bookmark.text;
        listItem.appendChild(link);

        // Nastavení odkazu na celý li element
        listItem.addEventListener('click', () => {
            window.location.href = bookmark.href;
        });

        list.appendChild(listItem);
    });
}

</script>

<script>
document.getElementById('searchForm').addEventListener('submit', function(event) {
    // Získáme hodnotu zadanou do pole pro hledání
    var searchQuery = document.querySelector('input[name="q"]').value;

    // Zkontrolujeme, zda zadaná adresa obsahuje domény'.cz' nebo '.com'
    if (
    searchQuery.endsWith('.cz') ||
    searchQuery.endsWith('.eu') ||
    searchQuery.endsWith('.com') ||
    searchQuery.endsWith('.net')
    ){
        // Pokud ano, přesměrujeme uživatele na zadanou adresu
        window.location.href = 'https://' + searchQuery;
        event.preventDefault(); // Zabráníme normálnímu odeslání formuláře
    }
});
</script>

<div class="main">

<form id="searchForm" method="get" target="_parent" action="https://www.google.com/search" style=" display: grid; flex-wrap: wrap;">
    <input type="text" name="q" oninput="searchBookmarks()" id="searchInput" placeholder="Search..." class="header_search" autocomplete="off">
    <ul id="bookmarkList"></ul>
</form>


     <div class="divs_jazykovka">
        <div class="jazykovka-1st">
            <div class="jazykovka jazykovka-dark" onclick="toggleLinks(this)"><p>Angličtina</p></div>
            <a href="https://www.deepl.com/cs/translator"><div class="jazykovka jazykovka-hide"><p>DeepL</p></div></a>
            <a href="https://englishfile4e.oxfordonlinepractice.com/app/dashboard"><div class="jazykovka jazykovka-hide"><p>Eng File</p></div></a> 
            <a href="https://slovniky.lingea.cz/anglicko-cesky/"><div class="jazykovka jazykovka-hide"><p>slovník</p></div></a>
            <a href="http://www.english-practice.at/"><div class="jazykovka jazykovka-hide"><p>practice</p></div></a>
            <a href="https://www.english-grammar.at/online_exercises/tenses/tenses_index.htm"><div class="jazykovka jazykovka-hide"><p>grammar</p></div></a>  
            <a href="https://www.engblocks.com/grammar/exercises/#google_vignette"><div class="jazykovka jazykovka-hide"><p>EngBlocks</p></div></a>  
            <a href="https://www.duolingo.com/learn"><div class="jazykovka jazykovka-hide"><p>Duolingo</p></div></a>  
        </div>
        <div class="jazykovka-2nd">
            <div class="jazykovka jazykovka-dark" onclick="toggleLinks(this)"><p>Matika</p></div>
            <a href="https://www.wolframalpha.com/"><div class="jazykovka jazykovka-hide"><p>Wolfram</p></div></a>
            <a href="https://eshop.scio.cz/Profil/OPBH/Online_Priprava_VS"><div class="jazykovka jazykovka-hide"><p>SCIO VŠ</p></div></a>
            <a href="https://www.priklady.eu/sk/riesene-priklady-matematika.alej"><div class="jazykovka jazykovka-hide"><p>priklady.eu</p></div></a>
            <a href="https://www.matematika.cz/"><div class="jazykovka jazykovka-hide"><p>mat cz</p></div></a>
            <a href="https://brilliant.org/courses/"><div class="jazykovka jazykovka-hide"><p>Brilliant</p></div></a>
            <a href="https://moodle-ostatni.cvut.cz/login/index.php"><div class="jazykovka jazykovka-hide"><p>moodle</p></div></a>
            <a href="http://www.realisticky.cz/ucebnice.php?id=4"><div class="jazykovka jazykovka-hide" style="font-size: 90%"><p>Realisticky</p></div></a>
        </div>
        <div class="jazykovka-3rd">
            <div class="jazykovka jazykovka-dark" onclick="toggleLinks(this)"><p>AI</p></div>
            <a href="https://chat.openai.com"><div class="jazykovka jazykovka-hide"><p>ChatGPT</p></div></a>
            <a href="https://gemini.google.com"><div class="jazykovka jazykovka-hide"><p>Gemini</p></div></a>
        </div>
    </div>

    <script>
function toggleLinks(clickedElement) {
    // Najde všechny následující odkazy pod kliknutým elementem
    const jazykovkadivs = clickedElement.parentElement.querySelectorAll('.jazykovka-hide');

    // Prochází všechny nalezené odkazy a mění jim styl zobrazení
    jazykovkadivs.forEach(jazykovkadiv => {
        jazykovkadiv.style.display = (jazykovkadiv.style.display === 'none' || jazykovkadiv.style.display === '') ? 'block' : 'none';
    });
}
</script>
</div>

<!--
    <div class="main_search" style="height: 127px; z-index: 1100">
    <div class="main_search_img" style="height: 127px"><img src="dnx_logo_header.png"></div>
    <div class="main_search_img">Google</div>
    <form method="get" target"_parent" action="https://www.google.com/search"><input type="text" name="q" size="50" placeholder="Hledat Googlem.." class="main_search_form"></form>
 </div>
 -->
 
    <div class="table" data-tags="přijímačky příprava ČVUT matika matematika">

        <p class="table_text">Příprava na přijímačky na VŠ:</p>
        <a href="https://jakserychlenaucit.cz" data-tags="Honza Kohut prokrastinace management time time-management organizace času"><div class="tile"><p>Jak se učit</p></div></a>
        <a href="http://www.realisticky.cz/ucebnice.php?id=4" data-tags="matika matematika"><div class="tile"><p>Realisticky</p></div></a>
        <a href="http://rubesz.cz/" data-tags="matika matematika"><div class="tile"><p>Rubesz sbírka</p></div></a>
        <a href="https://fit.cvut.cz/cs/uchazeci/prijimaci-rizeni/bakalarsky-studijni-program" data-tags="matika matematika"><div class="tile"><p>FIT ČVUT</p></div></a>
        <a href="https://isibalo.com/matematika" data-tags="matika matematika"><div class="tile"><p>Isibalo</p></div></a>
        <a href="https://michalheczko.cz/kombinatorika/index.php?p=kombinatorika" data-tags="matika matematika kombinace variace permutace"><div class="tile"><p>Kombinatorika</p></div></a>
        <a href="https://www.matweb.cz" data-tags="matika matematika polopatě"><div class="tile"><p>Matweb</p></div></a>
        
        
    </div>
    <div class="table" data-tags="služby">

        <p class="table_text">Služby:</p>
        <a href="https://facebook.com" data-tags="sociální síť fb"><div class="tile"><p>facebook</p></div></a>
        <a href="https://youtube.com" data-tags="yt"><div class="tile"><p>YouTube</p></div></a>
        <a href="https://gmail.com" data-tags="email"><div class="tile"><p>G-mail</p></div></a>
        <a href="https://www.disneyplus.com/cs-cz/home" data-tags="filmy seriály pohádky"><div class="tile"><p>Disney+</p></div></a>
        <a href="https://talktv.cz" data-tags="standashow Jaderná Jadrná věda Hranicí nerd tech IT"><div class="tile"><p>TALK</p></div></a>
        <table-hidden>
        <a href="https://www.netflix.com/browse"><div class="tile"><p>NETFLIX</p></div></a>
        <a href="https://play.hbomax.com/page/urn:hbo:page:home"><div class="tile"><p>HBO Max</p></div></a>
        <a href="https://minds.com/" data-tags="sociální síť"><div class="tile"><p>Minds</p></div></a>
        <a href="https://discord.com/app" data-tags="Skype messenger"><div class="tile"><p>Discord</p></div></a>
        <a href="https://app.element.io/" data-tags="messenger"><div class="tile"><p>Element</p></div></a>
        <a href="https://web.whatsapp.com/" data-tags="messenger"><div class="tile"><p>WhatsApp</p></div></a>
        <a href="https://pinafore.social/" data-tags="decentralizace decentralizovaný twitter X sociální síť"><div class="tile"><p>Mastodon</p></div></a></table-hidden>

    </div>
    <!-- RSS widget - www: rss.app
    <div class="table">
<rssapp-wall id="_w8ZndSZUIL7xgPnd"></rssapp-wall><script src="https://widget.rss.app/v1/wall.js" type="text/javascript" async></script>
     </div>  -->

    <div class="table" data-tags="geek nerd vzdělávání">

        <p class="table_text">Geek weby & vzdělávání:</p>
        <a href="https://www.animenewsnetwork.com/" data-tags="anime zprávy geek"><div class="tile"><p>Anime News</p></div></a>
        <a href="https://bronies.cz" data-tags="pony brony"><div class="tile"><p>bronies.cz</p></div></a>
        <a href="https://equestriadaily.com" data-tags="pony brony"><div class="tile"><p>Equestria Daily</p></div></a>
        <a href="https://www.svetserialu.to/" data-tags="anime seriály"><div class="tile"><p>Svět seriálů</p></div></a>
        <a href="https://topserialy.io/" data-tags="anime seriály"><div class="tile"><p>TOPserialy.io</p></div></a>
        <a href="https://igg-games.com" data-tags="hry crack torrent"><div class="tile"><p>igg-games</p></div></a>
        <a href="https://itnetwork.cz" data-tags="programování IT"><div class="tile"><p>ITnetwork</p></div></a>
        <table-hidden>
        <a href="https://www.soom.cz" data-tags="hackování programování IT"><div class="tile"><p>soom.cz</p></div></a>
        <a href="http://www.chovani.eu/" data-tags="etika"><div class="tile"><p>Chování.eu</p></div></a>
        <a href="https://www.marxists.org/cestina/index.htm" data-tags="socialismus"><div class="tile"><p>marxists.org</p></div></a>
        <a href="https://masaryk.mua.cas.cz/"><div class="tile"><p>Spisy TGM</p></div></a>
        <a href="https://mises.cz/" data-tags="libertarián urza svobodní ancap anarchokapitalismus trh"><div class="tile"><p>Mises</p></div></a>
        <a href="https://codeoflife.cz/" data-tags="biohacking"><div class="tile"><p>CodeOfLife</p></div></a>
        <a href="https://karolinafour.cz/" data-tags="recepty vaření"><div class="tile"><p>Karolina Four</p></div></a>
        <a href="https://nasclovek.cz"><div class="tile"><p>nasclovek</p></div></a>
        <a href="https://www.skolapameti.cz/pametove-techniky" data-tags="seberozvoj učení"><div class="tile"><p>škola paměti</p></div></a>
        </table-hidden>

        
    </div>

    <div class="table" data-tags="politika zprávy">

        <p class="table_text">Politické a zpravodajské weby:</p>
        <a href="https://www.institutvk.cz/newslettery" data-tags="václav václava klause klaus"><div class="tile"><p>Institut VK</p></div></a>
        <a href="https://www.piratskyinstitut.cz/" data-tags="piráti pirátský"><div class="tile"><p>Institut π</p></div></a>
        <a href="https://root.cz" data-tags="IT počítače linux ubuntu zprávy tech"><div class="tile"><p>root.cz</p></div></a>
        <a href="https://mandaty.cz" data-tags="průzkumy"><div class="tile"><p>mandaty.cz</p></div></a>
        <a href="https://piratskelisty.cz" data-tags="piráti"><div class="tile"><p>pirátské listy</p></div></a>
        <a href="https://parlamentnilisty.cz" data-tags="zprávy konzervativní"><div class="tile"><p>Parlamentní listy</p></div></a>
        <a href="https://irozhlas.cz" data-tags="zprávy český rozhlas"><div class="tile"><p>irozhlas.cz</p></div></a>
        <a href="https://www.aktualne.cz/" data-tags="zprávy aktuálně"><div class="tile"><p>aktualne.cz</p></div></a>
        <a href="https://hn.cz/" data-tags="zprávy Hospodářské noviny ekonomické ekonomie ekonomický"><div class="tile"><p>HN</p></div></a>
        <a href="https://www.respekt.cz/" data-tags="zprávy liberální"><div class="tile"><p>RESPEKT</p></div></a>
        <a href="https://www.reflex.cz/" data-tags="zprávy konzervativní liberální"><div class="tile"><p>Reflex</p></div></a>
        <a href="https://www.e15.cz/" data-tags="zprávy ekonomické ekonomie ekonomický"><div class="tile"><p>E15</p></div></a>
        <a href="https://www.info.cz/" data-tags="zprávy konzervativní"><div class="tile"><p>info.cz</p></div></a>
        <a href="https://echo24.cz/" data-tags="zprávy konzervativní"><div class="tile"><p>Echo24</p></div></a>
        <table-hidden>
        <a href="https://web.archive.org/web/20140821062159/https://www.mzv.cz/jnp/cz/udalosti_a_media/media_ve_svete/index.html" data-tags="zahraniční cizojazyčné anglické čínské čína zprávy"><div class="tile"><p>média ve světě</p></div></a>        
        <a href="https://a2larm.cz/" data-tags="liberální ekologie feminismus"><div class="tile"><p>a2larm</p></div></a>
        <a href="https://denikreferendum.cz/" data-tags="Deník Referendum liberální"><div class="tile"><p>Deník Referendum</p></div></a>
        <a href="https://denikn.cz/" data-tags="Deník N liberální "><div class="tile"><p>Deník N</p></div></a>

        <a href="https://www.politico.eu" data-tags="zahraniční cizojazyčné anglické zprávy"><div class="tile"><p>Politico</p></div></a>
        <a href="https://www.nytimes.com/international/section/politics" data-tags="New York Times NYT zahraniční cizojazyčné anglické zprávy"><div class="tile"><p>New York Times</p></div></a>
        <a href="https://www.euronews.com" data-tags="zahraniční cizojazyčné anglické zprávy"><div class="tile"><p>Euronews</p></div></a>
        <a href="https://www.euractiv.com/" data-tags="zahraniční cizojazyčné anglické zprávy"><div class="tile"><p>Euractiv</p></div></a>
        <a href="https://toutiao.com" data-tags="zahraniční cizojazyčné čínské čína zprávy"><div class="tile"><p>Toutiao</p></p></div></a>
        <a href="https://www.bilibili.tv/en" data-tags="čínské čína"><div class="tile"><p>BiliBili</p></p></div></a>
        <a href="https://www.ixigua.com/" data-tags="čínské čína"><div class="tile"><p>Ixigua</p></p></div></a>
        <a href="https://czech.cri.cn" data-tags="zahraniční cizojazyčné čínské čína zprávy"><div class="tile"><p>Čínský iRozhlas</p></p></div></a>
        <a href="https://www.globaltimes.cn" data-tags="zahraniční cizojazyčné čínské čína zprávy"><div class="tile"><p>Global Times</p></p></div></a></table-hidden>

</div>

     <div class="table"><table-hidden>
        <a href="https://webadmin.endora.cz/user/filemanager/edit/dnx.mzf.cz/web?file=%2Fdnx.mzf.cz%2Fweb%2Fhomepage.php" data-tags="endora dnx"><div class="tile"><p>editace homepage.php</p></div></a>        
        <a href="https://webadmin.endora.cz/user/filemanager/edit/dnx.mzf.cz/web?file=%2Fdnx.mzf.cz%2Fweb%2Fdesktop.php" data-tags="endora dnx"><div class="tile"><p>editace desktop.php</p></div></a>
        <a href="https://webadmin.endora.cz/user/filemanager/default/dnx.mzf.cz/web?file=%2Fdnx.mzf.cz%2Fweb%2Fhomepage.php" data-tags="endora dnx"><div class="tile"><p>Správa dnx.mzf.cz</p></div></a>
   
            <a href="https://eshop.scio.cz/Profil/OPBH/Online_Priprava_VS" data-tags="matika matematika přijímačky"><div class="jazykovka"><p>SCIO testy na VŠ</p></div></a>
            <a href="https://moodle-ostatni.cvut.cz/course/view.php?id=134" data-tags="matika matematika přijímačky"><div class="jazykovka"><p>ČVUT moodle</p></div></a>
            <a href="http://www.realisticky.cz/ucebnice.php?id=4" data-tags="matika matematika učebnice"><div class="jazykovka" style="font-size: 90%"><p>učebnice Realisticky</p></div></a>
            <a href="https://www.deepl.com/cs/translator" data-tags="překladač translate"><div class="jazykovka"><p>DeepL</p></div></a>
            <a href="https://englishfile4e.oxfordonlinepractice.com/app/dashboard" data-tags="angličtina oxford jazykovka english"><div class="jazykovka"><p>Eng File</p></div></a> 
            <a href="https://slovniky.lingea.cz/anglicko-cesky/" data-tags="angličtina"><div class="jazykovka"><p>slovník</p></div></a>
            <a href="http://www.english-practice.at/" data-tags="angličtina"><div class="jazykovka"><p>english-practice.at</p></div></a>
            <a href="https://www.english-grammar.at/online_exercises/tenses/tenses_index.htm" data-tags="angličtina english"><div class="jazykovka"><p>eng grammar</p></div></a>  
            <a href="https://www.engblocks.com/grammar/exercises/#google_vignette" data-tags="angličtina english"><div class="jazykovka"><p>EngBlocks</p></div></a>  
            
            <a href="https://chat.openai.com" data-tags="AI umělá inteligence"><div class="jazykovka"><p>ChatGPT</p></div></a>
            <a href="https://gemini.google.com" data-tags="AI umělá inteligence"><div class="jazykovka"><p>Gemini</p></div></a>
            
            <a href="https://www.pirati.cz/" data-tags="liberální politická pirátská strana"><div><p>Piráti</p></div></a>
            <a href="https://svobodni.cz/" data-tags="konzervativní libertariánská politická strana sso"><div><p>Svobodní</p></div></a>
            
            <a href="https://yayponies.no/books/book.php?category=Friendship+is+Magic&format=PDF" data-tags="mlp comics komiksy my little pony"><div><p>MLP komiksy</p></div></a>
            <a href="https://www.obchod.crew.cz/kategorie-21646/komiks/crew-manga/" data-tags="crew comics komiksy anime"><div><p>CREW komiksy</p></div></a>
        </table-hidden></div>


<style> @import "endora.css";</style> 
<div class="endora"><endora></div>
</body>
</html>