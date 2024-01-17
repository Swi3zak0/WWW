<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

.logowanie {
    max-width: 400px;
    margin: auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.heading {
    color: #333;
    text-align: center;
}

.logowanie table {
    width: 100%;
}

.logowanie td {
    padding: 10px;
}

.logowanie input {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
}

.lista-podstron ul {
    list-style-type: none;
    padding: 0;
}

.lista-podstron li {
    margin-bottom: 10px;
}

.lista-podstron a {
    text-decoration: none;
    color: #007bff;
}

.lista-podstron a:hover {
    text-decoration: underline;
}

.formularz-edycji label {
    display: block;
    margin-bottom: 5px;
}

.formularz-edycji textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
}

.formularz-edycji input[type="checkbox"] {
    margin-top: 5px;
}
</style>
<?php
include_once '../cfg.php';

session_start();


if (isset($_POST['submit_dodaj'])) {
    if (isset($_POST['id_podstrony'])) {
        ObslugaEdycjiPodstrony();
    } else {
        DodajPodstrone();
    }
}

if (isset($_POST['login_email']) && isset($_POST['login_pass'])) {
    if ($_POST['login_email'] == $login && $_POST['login_pass'] == $pass) {
        $_SESSION['zalogowany'] = true;
    } else {
        echo 'Błędny login lub hasło';
    }
}

if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true) {
    PokazPanelAdmina();
} else {
    echo FormularzLogowania();
    echo '<p><a href="contact.php">Skontaktuj się z nami</a></p> <p><a href="contact.php?action=przypomnijhaslo">Przypomnij hasło</a></p>';
}

if (isset($_GET['logout'])) {
    Wyloguj();
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    UsunPodstrone($delete_id);
}

function DodajPodstrone() {
    $conn = db_connect();

    $title = mysqli_real_escape_string($conn, $_POST['tytul']);
    $content = mysqli_real_escape_string($conn, $_POST['tresc']);
    $status = isset($_POST['status']) ? 1 : 0;

    $query = "INSERT INTO page_list (page_title, page_content, status) VALUES ('$title', '$content', $status)";
    mysqli_query($conn, $query);

    echo "Nowa podstrona została dodana.";

    mysqli_close($conn);
}

function ObslugaEdycjiPodstrony() {
    if (isset($_POST['submit_dodaj'])) {
        $conn = db_connect();

        $id = mysqli_real_escape_string($conn, $_POST['id_podstrony']);
        $title = mysqli_real_escape_string($conn, $_POST['tytul']);
        $content = mysqli_real_escape_string($conn, $_POST['tresc']);
        $status = isset($_POST['status']) ? 1 : 0;

        $query = "UPDATE page_list SET page_title='$title', page_content='$content', status=$status WHERE id=$id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Podstrona została zaktualizowana.";
        } else {
            echo "Błąd podczas aktualizacji podstrony: " . mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}

function UsunPodstrone($id) {
    $conn = db_connect();

    $id = mysqli_real_escape_string($conn, $id);

    $query = "DELETE FROM page_list WHERE id=$id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Podstrona została usunięta.";
        header("Location: admin.php"); // Przekierowanie po usunięciu
        exit();
    } else {
        echo "Błąd podczas usuwania podstrony: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}

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

function ListaPodstron() {
    $conn = db_connect(); 
    $query = "SELECT * FROM page_list ORDER BY id DESC LIMIT 100"; 
    $result = mysqli_query($conn, $query);

    echo '<div class="lista-podstron">';
    echo '<ul>';
    while ($row = mysqli_fetch_assoc($result)) {
        $id = htmlspecialchars($row['id']);
        $title = htmlspecialchars($row['page_title']);

        echo '<li>';
        echo "$id - Tytuł: $title ";
        // Przycisk edytowania
        echo "<a href='admin.php?edit_id=$id'>Edytuj</a> ";
        // Przycisk usuwania
        echo "<a href='admin.php?delete_id=$id' onclick='return confirm(\"Czy na pewno chcesz usunąć tę podstronę?\")'>Usuń</a>";
        echo '</li>';
    }
    echo '</ul>';
    echo '</div>';

    mysqli_close($conn);
}

function PobierzPodstrone($id) {
    $conn = db_connect(); 

    $id = mysqli_real_escape_string($conn, $id);

    $query = "SELECT * FROM page_list WHERE id = '$id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row;
    } else {
        return false;
    }
}

function EdytujPodstrone($id) {
    $podstrona = PobierzPodstrone($id);

    if ($podstrona) {
        // Dodaj otwierający tag formularza
        echo '<form action="admin.php" method="post" style="text-align: left">';
        echo '<input type="hidden" name="id_podstrony" value="' . $id . '">';

        echo '<label for="tytul">Tytuł:</label>';
        echo '<input type="text" name="tytul" value="' . htmlspecialchars($podstrona['page_title']) . '"><br>';

        echo '<label for="tresc">Treść:</label>';
        echo '<textarea name="tresc">' . htmlspecialchars($podstrona['page_content']) . '</textarea><br>';

        echo '<label for="aktywna">Aktywna:</label>';
        echo '<input type="checkbox" name="status" ' . ($podstrona['status'] ? 'checked' : '') . '><br>';

        echo '<input type="submit" name="submit_dodaj" value="Zapisz">';
        echo '</form>';
    } else {
        echo 'Podstrona o podanym identyfikatorze nie istnieje.';
    }
}

function PokazPanelAdmina() {
    echo "<h1>Panel Administratora</h1>";
    echo '<p><a href="?logout">Wyloguj</a></p>';
    ListaPodstron();
    
    if (isset($_GET['edit_id'])) {
        $edit_id = $_GET['edit_id'];
        EdytujPodstrone($edit_id);
    }

    echo '
    <form action="admin.php" method="post" style="text-align: left">
        <label for="tytul">Tytuł:</label><br>
        <input type="text" id="tytul" name="tytul"><br>
        <label for="tresc">Treść:</label><br>
        <textarea id="tresc" name="tresc"></textarea><br>
        <label for="status">Aktywna:</label>
        <input type="checkbox" name="status"><br>
        <input type="submit" name="submit_dodaj" value="Dodaj podstronę">
        <p><a href="sklep.php">Panel Kategorii</a></p>
        <p><a href="produkt.php">Panel Produktów</a></p>
    </form>';
}

function Wyloguj() {
    session_start();

    session_unset();

    session_destroy();

    header("Location: admin.php");
    exit();
}
?>
