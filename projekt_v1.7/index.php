<?php
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
    <form class="buttoms" method="post" name="background">
        <input type="button" value="yellow" onclick="changeBackground('#FFF000')">
        <input type="button" value="black" onclick="changeBackground('#000000')">
        <input type="button" value="white" onclick="changeBackground('FFFFFF')">
        <input type="button" value="green" onclick="changeBackground('00FF00')">
        <input type="button" value="blue" onclick="changeBackground('0000FF')">
        <input type="button" value="orange" onclick="changeBackground('FF8000')">
        <input type="button" value="grey" onclick="changeBackground('c0c0c0')">
        <input type="button" value="red" onclick="changeBackground('FF0000')">
    </form>
    <div id="clock-container">
        <p>Date: <span id="data"></span></p>
        <p>Time: <span id="zegarek"></span></p>
    </div>
    <div id="main">
        <nav>
            <a class="option main" href="index.php?idp=">Strona Główna</a><a class="option" href="index.php?idp=historia">Historia</a><a class="option" href="index.php?idp=gwiazdy">Gwiazdy NBA</a><a class="option" href="index.php?idp=filmy">Filmy</a><a class="option" href="index.php?idp=kontakt">Kontakt</a>
        </nav>
        <div id="text">
                <?php
                    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
                    $pageId = $_GET['idp'];
                    
                    if ($pageId == '') {
                        echo PokazPodstrone(1);
                    } elseif ($pageId == 'historia') {
                        echo PokazPodstrone(2);
                    } elseif ($pageId == 'gwiazdy') {
                        echo PokazPodstrone(3);
                    } elseif ($pageId == 'filmy') {
                        echo PokazPodstrone(4);
                    } elseif ($pageId == 'kontakt') {
                        echo PokazPodstrone(5);
                    }
                ?>
        </div>
    </div>
</body>
</html>
<?php
$nr_indeksu = '164463';
$nrGrupy = '1';
echo 'Autor: Patrycjusz Siwek '.$nr_indeksu.' grupa '.$nrGrupy.' <br /><br />';
?>
