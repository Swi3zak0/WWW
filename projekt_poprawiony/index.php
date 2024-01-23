<?php
// Podłączenie plików konfiguracyjnego i funkcji wyświetlania strony
include('cfg.php');
include('showpage.php');

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Language" content="pl" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="Author" content="Patrycjusz Siwek" />
	<link rel="stylesheet" href="css/arkusz.css">
	<title>Moje hobby to koszykówka</title>
    <script src="js/kolorujtlo.js" type="text/javascript"></script>
    <script src="js/timedate.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<script>window.onload = startClock;</script>
<body>
    <!-- Wyświetlanie zegara -->
    <div id="clock-container">
        <p>Date: <span id="data"></span></p>
        <p>Time: <span id="zegarek"></span></p>
    </div>
    <!-- Główny kontener strony -->
    <div id="main">
        <!-- Nawigacja strony -->
        <nav>
            <a class="option main" href="index.php?idp=">Strona Główna</a><a class="option" href="index.php?idp=skrypty">Skrypty</a><a class="option" href="index.php?idp=gwiazdy">Gwiazdy NBA</a><a class="option" href="index.php?idp=filmy">Filmy</a><a class="option" href="index.php?idp=kontakt">Kontakt</a>
        </nav>
         <!-- Treść strony pobrana na podstawie parametru idp z adresu URL -->
        <div id="text">
                <?php
                    // Pobranie parametru idp z adresu URL
                    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
                    $pageId = $_GET['idp'];
                    $link = db_connect();
                    // Wyświetlenie odpowiedniej treści na podstawie parametru idp
                    if ($pageId == '') {
                        echo PokazPodstrone(1, $link);
                    } elseif ($pageId == 'skrypty') {
                        echo PokazPodstrone(2, $link);
                    } elseif ($pageId == 'gwiazdy') {
                        echo PokazPodstrone(3, $link);
                    } elseif ($pageId == 'filmy') {
                        echo PokazPodstrone(4, $link);
                    } elseif ($pageId == 'kontakt') {
                        echo PokazPodstrone(5, $link);
                    }
                ?>
        </div>
    </div>
</body>
</html>
<?php
// Wyświetlenie informacji o autorze na końcu strony
$nr_indeksu = '164463';
$nrGrupy = '1';
echo 'Autor: Patrycjusz Siwek '.$nr_indeksu.' grupa '.$nrGrupy.' <br /><br />';
?>
