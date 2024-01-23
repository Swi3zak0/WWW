<?php
// dane admina
    $login = 'admin@wp.pl';
    $pass = 'admin';
// funkcja do logowania do bazy danych
function db_connect(){
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $baza = 'moja_strona';
    {
        $link = new mysqli($dbhost, $dbuser, $dbpass, $baza);

        if ($link->connect_error) {
            die("Zerwane połaczenie: " . $link->connect_error);
        }
        return $link;
    }
}

