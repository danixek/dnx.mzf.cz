<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="dnx_logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="pattern.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="Můj osobní web. Zajímám se o programování, politickou literaturu a osobní seberozvoj.">
    <title>dnx.cz</title>
    
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-JLWMMCFJX5"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-JLWMMCFJX5');
</script>

    
</head>
<script type="text/javascript" src="https://panzi.github.io/Browser-Ponies/basecfg.js" id="browser-ponies-config"></script><script type="text/javascript" src="https://panzi.github.io/Browser-Ponies/browserponies.js" id="browser-ponies-script"></script><script type="text/javascript">/* <![CDATA[ */ (function (cfg) {BrowserPonies.setBaseUrl(cfg.baseurl);BrowserPonies.loadConfig(BrowserPoniesBaseConfig);BrowserPonies.loadConfig(cfg);})({"baseurl":"https://panzi.github.io/Browser-Ponies/","fadeDuration":500,"volume":1,"fps":25,"speed":2,"audioEnabled":false,"showFps":false,"showLoadProgress":true,"speakProbability":0.01,"spawn":{
"rainbow dash":1,"twilight sparkle":1},"autostart":true}); /* ]]> */</script>
<body>

<?php
// Název složky s obrázky
$directory = "../code";

// Získej seznam všech souborů v adresáři
$files = glob($directory . "/*.{png,gif,jpg}", GLOB_BRACE);

// Vylosuj náhodný soubor ze seznamu
$randomFile = $files[array_rand($files)];

// Vytvořte CSS pravidlo pro nastavení pozadí těla
$background = "body { 
    background-image: url('$randomFile');
    background-size: cover; /* Roztáhne obrázek tak, aby pokryl celé tělo */
}";




// Získání hodnoty parametru 'e' z URL
$errorCode = isset($_GET['e']) ? $_GET['e'] : null;

// Funkce pro získání chybové zprávy na základě kódu chyby
function getErrorMessage($code) {
    switch ($code) {
        case '404':
            return 'Stránka neexistuje';
        case '401':
            return 'Neautorizovaný přístup';
        case '403':
            return 'Zakázaný přístup';
        default:
            return 'Neznámá chyba';
    }
}

// Získání chybové zprávy
$errorMessage = getErrorMessage($errorCode);
?>

<style>
<?php echo $background; ?>
        .logo {width: 300px; height: 80px; position: relative; top: 250px; margin-left: auto; margin-right: auto}
        .dnx_img {width: 300px }
        .work_in_progress {position: relative; left: 20px; font-size: 27px; border: none}

        .body {top: 400px; margin-left: 300px; margin-right: 300px; min-width: 500px; position: relative}
        .body_div {background-color: rgb(60,60,60); width: 100%; border-radius: 20px}
        .body_div_div {padding: 30px}



//*
.personal_info {border-radius: 10px; background-color: rgb(250,250,250)}
.personal_links {border-radius: 10px; background-color: rgb(250,250,250)} *//
.projects {border-radius: 10px; background-color: rgb(250,250,250)}
        .personal_info li {text-align: center; line-height: 1.5}
        .personal_links, .personal_info {margin: 0 auto; list-style-type: none}
        .personal_links h2, .personal_info h2 { text-align: center;}
        .links {display: grid;grid-template-columns: auto auto auto auto; gap: 5px;list-style-type: none; padding: 0;}
        .links li {padding: 5px 0;}
        .links li:nth-child(odd), .projects_links li:nth-child(odd) { text-align: left; padding-left: 20px}
        .links li:nth-child(even), .projects_links li:nth-child(even) { text-align: left;}
        .links a {text-decoration: none;color: #55f;}
        
        .projects_links {display: block;align-items: center; list-style-type: none}
        .projects_links li:nth-child(1) {display: inline-block; list-style-type: none; padding-bottom: 10px; position: relative; right: 50px; width: 400px}
        .projects_links li:nth-child(2) {display: inline-block; list-style-type: none; padding-bottom: 10px; position: relative; right: 27px; width: 400px}
        .projects_links a {color: #55f;text-decoration: none;}


</style>

    <div class="logo">
        <b style="margin-left: 60px; margin-right: 60px; position: relative; font-size: 100px"><?php echo htmlspecialchars($errorCode); ?></b> <br>
        <b class="work_in_progress"><?php echo htmlspecialchars($errorMessage); ?></b>
    </div>


    
</body>
</html>