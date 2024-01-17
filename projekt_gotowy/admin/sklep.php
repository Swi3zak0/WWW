<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

.panel-kategorii {
    max-width: 800px;
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

.panel-kategorii table {
    width: 100%;
}

.panel-kategorii td {
    padding: 10px;
}

.panel-kategorii input {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
}

.panel-kategorii ul {
    list-style-type: none;
    padding: 0;
}

.panel-kategorii li {
    margin-bottom: 10px;
}

.panel-kategorii a {
    text-decoration: none;
    color: #007bff;
}

.panel-kategorii a:hover {
    text-decoration: underline;
}

.formularz-edycji label {
    display: block;
    margin-bottom: 5px;
}

.formularz-edycji input[type="text"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
}

.formularz-edycji input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.formularz-edycji input[type="submit"]:hover {
    background-color: #0056b3;
}
</style>
<?php
include_once '../cfg.php';

session_start();

if (isset($_POST['submit_dodaj_kategorie'])) {
    if (isset($_POST['id_kategorii'])) {
        ObslugaEdycjiKategorii();
    } else {
        DodajKategorie();
    }
}


function ListaKategorii($parent = 0) {
    $conn = db_connect(); 
    $query = "SELECT * FROM category_list WHERE matka = $parent ORDER BY id DESC"; 
    $result = mysqli_query($conn, $query);

    echo '<ul>';

    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $nazwa = $row['nazwa'];

        echo '<li>';
        echo "ID: $id - Nazwa: $nazwa ";
        
        echo "<a href='sklep.php?edit_category_id=$id'>Edytuj</a> ";
        echo "<a href='sklep.php?delete_category_id=$id' onclick='return confirm(\"Czy na pewno chcesz usunąć tę kategorię?\")'>Usuń</a>";

        ListaKategorii($id);

        echo '</li>';
    }

    echo '</ul>';
    mysqli_close($conn);
}


if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true) {
    PokazPanelAdminaKategorii();
} else {
    echo FormularzLogowania();
    echo '<p><a href="contact.php">Skontaktuj się z nami</a></p> <p><a href="contact.php?action=przypomnijhaslo">Przypomnij hasło</a></p>';
}

if (isset($_GET['logout'])) {
    Wyloguj();
}

if (isset($_GET['delete_category_id'])) {
    $delete_category_id = $_GET['delete_category_id'];
    UsunKategorie($delete_category_id);
}

function DodajKategorie() {
    $conn = db_connect();

    $matka = mysqli_real_escape_string($conn, $_POST['matka']);
    $nazwa = mysqli_real_escape_string($conn, $_POST['nazwa']);

    $query = "INSERT INTO category_list (matka, nazwa) VALUES ('$matka', '$nazwa')";
    mysqli_query($conn, $query);

    echo "Nowa kategoria została dodana.";

    mysqli_close($conn);
}

function ObslugaEdycjiKategorii() {
    if (isset($_POST['submit_dodaj_kategorie'])) {
        $conn = db_connect();

        $id = mysqli_real_escape_string($conn, $_POST['id_kategorii']);
        $matka = mysqli_real_escape_string($conn, $_POST['matka']);
        $nazwa = mysqli_real_escape_string($conn, $_POST['nazwa']);

        $query = "UPDATE category_list SET matka='$matka', nazwa='$nazwa' WHERE id=$id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Kategoria została zaktualizowana.";
        } else {
            echo "Błąd podczas aktualizacji kategorii: " . mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}

function UsunKategorie($id) {
    $conn = db_connect();

    $id = mysqli_real_escape_string($conn, $id);

    $query = "DELETE FROM category_list WHERE id=$id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Kategoria została usunięta.";
        header("Location: sklep.php");
        exit();
    } else {
        echo "Błąd podczas usuwania kategorii: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}

function PokazPanelAdminaKategorii() {
    echo "<h1>Panel Administratora Kategorii</h1>";
    echo '<p><a href="?logout">Wyloguj</a></p>';
    echo '<p><a href="admin.php">Powrót do Panelu Admina</a></p>';
    echo '<div>';
    ListaKategorii();
    echo '</div>';

    if (isset($_GET['edit_category_id'])) {
        $edit_category_id = $_GET['edit_category_id'];
        EdytujKategorie($edit_category_id);
    }

    echo '
    <form action="sklep.php" method="post" style="text-align: left">
        <label for="matka">Matka:</label><br>
        <input type="text" id="matka" name="matka"><br>
        <label for="nazwa">Nazwa:</label><br>
        <input type="text" id="nazwa" name="nazwa"><br>
        <input type="submit" name="submit_dodaj_kategorie" value="Dodaj kategorię">
    </form>';
}

function EdytujKategorie($id) {
    $kategoria = PobierzKategorie($id);

    if ($kategoria) {
        echo '<form action="sklep.php" method="post" style="text-align: left">';
        echo '<input type="hidden" name="id_kategorii" value="' . $id . '">';
        
        echo '<label for="matka">Matka:</label>';
        echo '<input type="text" name="matka" value="' . htmlspecialchars($kategoria['matka']) . '"><br>';
        
        echo '<label for="nazwa">Nazwa:</label>';
        echo '<input type="text" name="nazwa" value="' . htmlspecialchars($kategoria['nazwa']) . '"><br>';
        
        echo '<input type="submit" name="submit_dodaj_kategorie" value="Zapisz">';
        echo '</form>';
    } else {
        echo 'Kategoria o podanym identyfikatorze nie istnieje.';
    }
}


function PobierzKategorie($id) {
    $conn = db_connect(); 

    $id = mysqli_real_escape_string($conn, $id);

    $query = "SELECT * FROM category_list WHERE id = '$id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row;
    } else {
        return false;
    }
}

function Wyloguj() {
    session_start();

    session_unset();

    session_destroy();

    header("Location: admin.php");
    exit();
}
?>
