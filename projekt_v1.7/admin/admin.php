<?php

function FormularzLogowania()
{
    $wynik = '
    <div class="logowanie">
        <h1 class="heading"> Panel CMS:</h1>
        <div class="logowanie">
            <form method="post" name="LoginForm" enctype="multipart/form-data" action="' . $_SERVER['REQUEST_URI'] . '">
                <table class="logowanie">
                    <tr><td class="log4_t">[email]</td><td><input type="text" name="login_email" class="logowanie" /></td></tr>
                    <tr><td class="log4_t">[haslo]</td><td><input type="password" name="login_pass" class="logowanie" /></td></tr>
                    <tr><td>&nbsp;</td><td><input type="submit" name="x1_submit" class="logowanie" value="zaloguj" /></td></tr>
                </table>
            </form>
        </div>
    </div>';

    return $wynik;
}

function ListaPodstron($id_clear)
{

    $query = "Select * FROM page-list WHERE id='$id_clear' ORDER BY data DESC LIMIT 100";
     $result = mysqli_query($query);

     while($row = mysqli_fetch_array($result))
     {
         $row['id'].' '.$row['tytul'].' <br />';
     }
}

function EdytujPodstrone($id) {
    $podstrona = PobierzPodstrone($id);

    if ($podstrona) {
        echo '<form method="post" action="zapisz_edycje.php">';
        echo '<input type="hidden" name="id_podstrony" value="' . $id . '">';

        echo '<label for="tytul">Tytuł:</label>';
        echo '<input type="text" name="tytul" value="' . htmlspecialchars($podstrona['tytul']) . '"><br>';

        echo '<label for="tresc">Treść:</label>';
        echo '<textarea name="tresc">' . htmlspecialchars($podstrona['tresc']) . '</textarea><br>';

        echo '<label for="aktywna">Aktywna:</label>';
        echo '<input type="checkbox" name="aktywna" ' . ($podstrona['aktywna'] ? 'checked' : '') . '><br>';

        echo '<input type="submit" value="Zapisz">';
        echo '</form>';
    } else {
        echo 'Podstrona o podanym identyfikatorze nie istnieje.';
    }
}


?>
