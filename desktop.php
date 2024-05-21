<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="dnx_logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="pattern.css">
    <audio id="notification-sound" src="retrocoin.mp3" preload="auto"></audio>
    <audio id="notification-sound2" src="retrocoin.mp3" preload="auto"></audio>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Desktop - dnx.cz</title>
    
</head>
<body>
    
    <?php
// Získání hodnoty parametru 'm' z URL
$monitor = isset($_GET['m']) ? $_GET['m'] : '';
$backgroundimageurl = "images/" . (isset($_GET['b']) ? $_GET['b'] : 'mlp1.png');

// Nastavení hodnot pro různé módy
switch ($monitor) {
    case '2':

        /* Tradingview PHP settings - ?m=2 */
        $tradingviewbottom1 = 60;
        $tradingviewbottom2 = 60;
        $tradingviewleft1 = 120;
        $tradingviewleft2 = 900;
        $tradingviewwidth1 = "37%";
        $tradingviewwidth2 = "37%";
        $tradingviewheight1 = "35%";
        $tradingviewheight2 = "28%";
        break;

    case '1':

        /* Tradingview PHP settings - ?m=1 */
        $tradingviewbottom1 = 630;
        $tradingviewbottom2 = 330;
        $tradingviewleft1 = 70;
        $tradingviewleft2 = 70;
        $tradingviewwidth1 = "22%";
        $tradingviewwidth2 = "22%";
        $tradingviewheight1 = "37%";
        $tradingviewheight2 = "27%";
        break;

    default:
        // Není zadán platný režim, můžete zde nastavit výchozí hodnoty nebo přesměrovat na jinou stránku
        header("Location: http://dnx.mzf.cz/desktop?m=1");
        exit();
}

// Generování CSS stylů na základě hodnot

        $topValue = 110;
        $rightValue = -20;
echo "
<style>

    body {background-image: url('" . $backgroundimageurl . "') !important}

    .my-bitcoins {
        position: absolute;
        top: {$topValue}px;
        right: {$rightValue}px;
    }
    #my-bitcoins-image {
        position: absolute;
        top: " . ($topValue + 20) . "px;
        right: " . ($rightValue + 33) . "px;
        z-index: 5;
    }
    #tradingview-widget1 {position: absolute; left: " . $tradingviewleft1 . "px; bottom: " . $tradingviewbottom1 . "px}
    #tradingview-widget2 {position: absolute; left: " . $tradingviewleft2 . "px; bottom: " . $tradingviewbottom2 . "px}
    coin-stats-portfolio-widget table, coin-stats-portfolio-widget a {visibility: hidden}
    coin-stats-portfolio-widget div div {border-bottom-left-radius: 20px !important}
    
    body {background-color: rgba !important; overflow: hidden; background-size: cover; background-repeat: no-repeat;}
    .pomodoro-button {height: 30px; width: 90px; color: rgb(250,250,250); font-size: 14px; background: rgba(50,50,50,0.5); border: 2px solid rgb(200,200,200,0.5); border-radius: 40px; position: absolute; top: 215px; right: 187px; z-index: 5;}
    
    .timer-button {height: 30px; width: 50px; color: rgb(250,250,250); font-size: 14px; background: rgba(50,50,50,0.5); border: 2px solid rgb(200,200,200,0.5); border-radius: 40px; position: absolute; top: 215px; right: 130px; z-index: 5;}
    #timer-display {position: absolute; right: 160px; top: 30px; font-size: 50px; width: 50px}
    .reload-button {height: 30px; width: 30px; color: rgb(250,250,250); font-size: 17px; transform: rotate(100deg); background: rgba(50,50,50,0.5); border: 2px solid rgb(200,200,200,0.5); border-radius: 40px; position: absolute; top: 215px; right: 16px; z-index: 5;}
    pony-button {height: 25px; width: 60px; color: rgb(250,250,250); font-size: 12px; background: rgba(50,50,50,0.5); border: 2px solid rgb(200,200,200,0.5); border-radius: 40px; position: absolute; top: 215px; right: 60px; z-index: 5; display: flex; justify-content: center; align-items: center;}
    pony-button a:link {color: rgb(250,250,250); text-decoration: none; display: flex; justify-content: center; align-items: center}
</style>
";
?>
    

<div class="mainbody">
</div>

<?php
$ponySpawnPHP = array(
 /* "applejack" => 1,
    "fluttershy" => 1,
    "pinkie pie" => 1,
    "rarity" => 1,  */
    "rainbow dash" => 1,
    "twilight sparkle" => 1
);
    $ponySpawnJSON = htmlspecialchars(json_encode($ponySpawnPHP), ENT_QUOTES, 'UTF-8');  ?>


           <button onclick="location.reload();" class="reload-button">&#x21bb;</button>
<pony-button><a href="javascript:(function (srcs,cfg) { var cbcount = 1; var callback = function () { -- cbcount; if (cbcount === 0) { BrowserPonies.setBaseUrl(cfg.baseurl); if (!BrowserPoniesBaseConfig.loaded) { BrowserPonies.loadConfig(BrowserPoniesBaseConfig); BrowserPoniesBaseConfig.loaded = true; } BrowserPonies.loadConfig(cfg); if (!BrowserPonies.running()) BrowserPonies.start(); } }; if (typeof(BrowserPoniesConfig) === &quot;undefined&quot;) { window.BrowserPoniesConfig = {}; } if (typeof(BrowserPoniesBaseConfig) === &quot;undefined&quot;) { ++ cbcount; BrowserPoniesConfig.onbasecfg = callback; } if (typeof(BrowserPonies) === &quot;undefined&quot;) { ++ cbcount; BrowserPoniesConfig.oninit = callback; } var node = (document.body || document.documentElement || document.getElementsByTagName('head')[0]); for (var id in srcs) { if (document.getElementById(id)) continue; if (node) { var s = document.createElement('script'); s.type = 'text/javascript'; s.id = id; s.src = srcs[id]; node.appendChild(s); } else { document.write('\u003cscript type=&quot;text/javscript&quot; src=&quot;'+ srcs[id]+'&quot; id=&quot;'+id+'&quot;\u003e\u003c/script\u003e'); } } callback();
})({&quot;browser-ponies-script&quot;:&quot;https://panzi.github.io/Browser-Ponies/browserponies.js&quot;,&quot;browser-ponies-config&quot;:&quot;https://panzi.github.io/Browser-Ponies/basecfg.js&quot;},{&quot;baseurl&quot;:&quot;https://panzi.github.io/Browser-Ponies/&quot;,&quot;fadeDuration&quot;:500,&quot;volume&quot;:1,&quot;fps&quot;:25,&quot;speed&quot;:3,&quot;audioEnabled&quot;:false,&quot;showFps&quot;:false,&quot;showLoadProgress&quot;:true,&quot;speakProbability&quot;:0.1,&quot;spawn&quot;:<?php echo $ponySpawnJSON; ?>});void(0)">Ponies!</a>
</pony-button>
    <button onclick="startPomodoro()" class="pomodoro-button">Pomodoro</button>
    <button onclick="toggleTimer()" class="timer-button">Timer</button>
    <div id="timer-display"></div>
    <script>
    let interval;
    let currentTime = 30 * 60; // 30 minutes in seconds
    let isWorkSession = true; // Track if it's a work session or break session

        function startPomodoro() {
            if (interval) {
               clearInterval(interval);
            }
    
            interval = setInterval(function() {
                const minutes = Math.floor(currentTime / 60);
                const seconds = currentTime % 60;
                document.getElementById("timer-display").innerText = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        
                if (currentTime > 0) {
                    currentTime--;
                } else {
                    clearInterval(interval);
                    playSound();
                    if (isWorkSession) {
                        alert("Pomodoro session completed! Take a short break.");
                        currentTime = 5 * 60; // 5 minutes break
                    } else {
                        alert("Break is over! Time to work.");
                        currentTime = 30 * 60; // 30 minutes work
                    }
                    isWorkSession = !isWorkSession; // Toggle session type
                    startPomodoro(); // Restart the timer
                }
            }, 1000);
        }

            function playSound() {
                const sound = document.getElementById("notification-sound");
                sound.play();
            }
        
        let interval2;
        let currentTime2 = 30 * 60; // 30 minutes in seconds
        let isThirtyMinutes2 = true;

        function startTimer() {
            if (interval2) {
                clearInterval(interval2);
            }

            interval2 = setInterval(function() {
                const minutes = Math.floor(currentTime2 / 60);
                const seconds = currentTime2 % 60;
                document.getElementById("timer-display").innerText = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

                if (currentTime2 > 0) {
                    currentTime2--;
                } else {
                    clearInterval(interval2);
                    playSound2();
                    toggleTimerDuration();
                }
            }, 1000);
        }

        function toggleTimer() {
            if (interval2) {
                clearInterval(interval2);
            }
            toggleTimerDuration();
            startTimer();
        }

        function toggleTimerDuration() {
            if (isThirtyMinutes2) {
                currentTime2 = 5 * 60; // 5 minutes in seconds
            } else {
                currentTime2 = 30 * 60; // 30 minutes in seconds
            }
            isThirtyMinutes2 = !isThirtyMinutes2;
            playSound2();
        }

        function playSound2() {
            const sound = document.getElementById("notification-sound2");
            sound.play();
        }


    </script>

<div class="tradingview-widget-container" id="tradingview-widget1">

<!-- TradingView Widget BEGIN -->
<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-symbol-overview.js" async>
 {
  "symbols": [
    [
      "BITSTAMP:BTCUSD|5d|CZK"
    ]
  ],
  "chartOnly": false,
  "width": "<?= $tradingviewwidth1 ?>",
  "height": "<?= $tradingviewheight1 ?>",
  "locale": "cs",
  "colorTheme": "dark",
  "isTransparent": true,
  "autosize": false,
  "showVolume": false,
  "showMA": false,
  "hideDateRanges": false,
  "hideMarketStatus": false,
  "hideSymbolLogo": false,
  "scalePosition": "no",
  "scaleMode": "Normal",
  "fontFamily": "-apple-system, BlinkMacSystemFont, Trebuchet MS, Roboto, Ubuntu, sans-serif",
  "fontSize": "10",
  "fontColor": "rgba(209, 212, 220, 1)",
  "noTimeScale": false,
  "valuesTracking": "1",
  "changeMode": "price-and-percent",
  "chartType": "area",
  "maLineColor": "#2962FF",
  "maLineWidth": 1,
  "maLength": 9,
  "lineWidth": 2,
  "lineType": 0,
  "dateRanges": [
    "1d|1",
    "5d|5",
    "1w|15",
    "1m|30",
    "3m|60",
    "6m|120",
    "12m|1D",
    "60m|1W",
    "all|1M"
  ],
  "lineColor": "rgba(255, 152, 0, 1)",
  "topColor": "rgba(255, 255, 0, 0)",
  "dateFormat": "dd/MM/yyyy"
  
 }
  </script>
</div>

<div class="tradingview-widget-container" id="tradingview-widget2">

<!-- TradingView Widget BEGIN -->
<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-symbol-overview.js" async>
 {
  "symbols": [
    [
      "BITSTAMP:BTCUSD|1M|CZK"
    ]
  ],
  "chartOnly": true,
  "width": "<?= $tradingviewwidth2 ?>",
  "height": "<?= $tradingviewheight2 ?>",
  "locale": "cs",
  "colorTheme": "dark",
  "isTransparent": true,
  "autosize": false,
  "showVolume": false,
  "showMA": false,
  "hideDateRanges": false,
  "hideMarketStatus": false,
  "hideSymbolLogo": false,
  "scalePosition": "no",
  "scaleMode": "Normal",
  "fontFamily": "-apple-system, BlinkMacSystemFont, Trebuchet MS, Roboto, Ubuntu, sans-serif",
  "fontSize": "10",
  "fontColor": "rgba(209, 212, 220, 1)",
  "noTimeScale": false,
  "valuesTracking": "1",
  "changeMode": "price-and-percent",
  "chartType": "area",
  "maLineColor": "#2962FF",
  "maLineWidth": 1,
  "maLength": 9,
  "lineWidth": 2,
  "lineType": 0,
  "dateRanges": [
    "1d|1",
    "5d|5",
    "1w|15",
    "1m|30",
    "3m|60",
    "6m|120",
    "12m|1D",
    "60m|1W",
    "all|1M"
  ],
  "lineColor": "rgba(255, 152, 0, 1)",
  "topColor": "rgba(255, 255, 0, 0)",
  "dateFormat": "dd/MM/yyyy"
  
 }
  </script>
</div>
<!-- TradingView Widget END -->


<img onclick="cryptowallet()" id="my-bitcoins-image" src="data:image/png;base64,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"
style="height: 27px; width: 27px; z-index: 4">
<div class="my-bitcoins" id="my-bitcoins"><script async src="https://static.coinstats.app/widgets/portfolio-widget.js"></script>
<coin-stats-portfolio-widget locale="en" currency="CZK" bg-color="#1C1B1B" status-up-color="#74D492" status-down-color="#FE4747" text-color="#FFFFFF" border-color="rgba(255,255,255,0.15)" widgetType="small" coins-count="3" font="Roboto, Arial, Helvetica" link="1rL7qH" rotate-button-color="rgba(255, 255, 255, 0.35)" width="300" ></coin-stats-portfolio-widget>
</div>
<script>
    function cryptowallet() {
    var myBitcoinsDiv = document.getElementById('my-bitcoins');
    var bitcoinImage = document.getElementById('my-bitcoins-image');

    // Zjistí aktuální hodnoty stylů
    var displayStyle = window.getComputedStyle(myBitcoinsDiv).getPropertyValue('display');
    var opacityStyle = window.getComputedStyle(bitcoinImage).getPropertyValue('opacity');

    // Přepne viditelnost a opacitu
    if (displayStyle === 'none' || opacityStyle === '0') {
        myBitcoinsDiv.style.display = 'block';
        bitcoinImage.style.opacity = '1';
    } else {
        myBitcoinsDiv.style.display = 'none';
        bitcoinImage.style.opacity = '0.1'; // Nastavte požadovanou hodnotu
    }
}

</script>




<style> @import "endora.css";</style> 
<div class="endora"><endora></div>
</body>
</html>