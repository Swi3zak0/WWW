<?php
    $nr_indeksu = '164463';
    $nr_grupy = '1';

    echo 'Patrycjusz Siwek: .'.$nr_indeksu.' grupa '.$nr_grupy.'<br /> <br />';

    echo 'Wykorzystanie include() <br/> <br/>';
    include "test.php";
    echo 'Patrycjusz Siwek: wiek:'.$wiek.'lat. Ulubiony kolor '.$color.'<br /><br />';
    
    echo 'Wykorzystanie require_once<br/><br />';
    $przyklad = require_once('test2.php');
    echo ''.$przyklad.'<br/><br/>';

    echo 'Wykorzystanie funkcji if<br/><br/>';
    $a = 10;
    $b = 5;
    if ($a > $b)
        echo 'Wartosc a jest wieksza<br/><br/>';

    echo 'Wykorzystanie funkcji else<br/><br/>';
    $a = 5;
    $b = 10;
    if ($a > $b)
        echo 'Wartosc a jest wieksza<br/><br/>';
    else
        echo 'Wartosc b jest wieksza<br/><br/>';

    echo 'Wykorzystanie funkcji elseif<br/><br/>';
    $a = 10;
    $b = 10;
    if ($a > $b)
        echo 'Wartosc a jest wieksza<br/><br/>';
    elseif ($a == $b)
        echo 'Wartosci sa rowne<br/><br/>';
    else
        echo 'Wartosc b jest wieksza<br/><br/>';

    echo 'Wykorzystanie funkcji switch<br/><br/>';
    $x = 3;
    switch ($x){
        case 0:
            echo 'Wartosc wynosi 0<br/><br/>';
            break;
        case 1:
            echo 'Wartosc wynosi 1<br/><br/>';
            break;
        case 2:
            echo 'Wartosc wynosi 2<br/><br/>';
            break;
        case 3:
            echo 'Wartosc wynosi 3<br/><br/>';
            break;
    }

    echo 'Wykorzystanie funkcji while<br/><br/>';
    $x = 1;
    while ($x <= 10){
        echo $x++;
    }
    echo '<br/><br/>';

    echo 'Wykorzystanie funkcji for<br/><br/>';
    for($i = 1; $i <=10; $i++){
        echo $i;
    }
    echo '<br/><br/>';

    echo 'Wykorzystanie metody GET<br/><br/>';
    $_GET['name'] = 'Patryk';
    echo 'Hello ' . htmlspecialchars($_GET["name"]) . '!';
    echo '<br/><br/>';

    echo 'Wykorzystanie metody POST<br/><br/>';
    $_POST['name'] = 'Wojtek';
    echo 'Hello ' . htmlspecialchars($_POST['name']) . '!';
    echo '<br/><br/>';

    echo 'Wykorzystanie metody SESSION<br/><br/>';
    $_SESSION['name'] = 'Kuba';
    echo 'Hello ' . htmlspecialchars($_SESSION['name']) . '!';
    echo '<br/><br/>';
?>
