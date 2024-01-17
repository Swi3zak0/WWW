<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

h1 {
    color: #333;
}

form {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input, textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

ul {
    list-style-type: none;
    padding: 0;
}

li {
    margin-bottom: 10px;
}

a {
    text-decoration: none;
    color: #007bff;
}

a:hover {
    text-decoration: underline;
}

.container {
    max-width: 800px;
    margin: auto;
}

.cart {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
}

.cart h2 {
    color: #333;
}

.cart ul {
    padding: 0;
}

.cart li {
    margin-bottom: 10px;
}

.success-message {
    color: #28a745;
}

.error-message {
    color: #dc3545;
}
</style>

<?php
include_once '../cfg.php';

session_start();


if (isset($_POST['submit_dodaj_produkt'])) {
    if (isset($_POST['id_produktu'])) {
        ObslugaEdycjiProduktu();
    } else {
        DodajProdukt();
    }
}

function PokazPanelAdminaProduktu() {
    echo "<h1>Panel Administratora Produktu</h1>";
    echo '<p><a href="?logout">Wyloguj</a></p>';
    echo '<p><a href="admin.php">Powrót do Panelu Admina</a></p>';
    echo '<div>';
    ListaProduktow();
    echo '</div>';

    if (isset($_GET['edit_product_id'])) {
        $edit_product_id = $_GET['edit_product_id'];
        EdytujProdukt($edit_product_id);
    }
    echo '<div style="float: left; margin-right: 20px;">';
    echo '
    <form action="produkt.php" method="post" style="text-align: left">
        <label for="tytul">Tytul:</label><br>
        <input type="text" id="tytul" name="tytul"><br>
        <label for="opis">Opis:</label><br>
        <textarea id="opis" name="opis"></textarea><br>
        <label for="data_utworzenia">Data utworzenia:</label><br>
        <input type="text" id="data_utworzenia" name="data_utworzenia"><br>
        <label for="data_modyfikacji">Data modyfikacji:</label><br>
        <input type="text" id="data_modyfikacji" name="data_modyfikacji"><br>
        <label for="data_wygasniecia">Data wygaśnięcia:</label><br>
        <input type="text" id="data_wygasniecia" name="data_wygasniecia"><br>
        <label for="cena_netto">Cena netto:</label><br>
        <input type="text" id="cena_netto" name="cena_netto"><br>
        <label for="podatek_vat">Podatek VAT:</label><br>
        <input type="text" id="podatek_vat" name="podatek_vat"><br>
        <label for="ilosc">Ilość:</label><br>
        <input type="text" id="ilosc" name="ilosc"><br>
        <label for="status">Status:</label><br>
        <input type="checkbox" id="status" name="status" value="1"><br>

        <label for="kategoria">Kategoria:</label><br>
        <select id="kategoria" name="kategoria">';
        $categories = PobierzKategorie();
        foreach ($categories as $category) {
            echo '<option value="' . $category['id'] . '">' . $category['nazwa'] . '</option>';
        }
        echo '</select><br>';

        echo '
        <label for="gabaryt">Gabaryt:</label><br>
        <input type="text" id="gabaryt" name="gabaryt"><br>
        <label for="zdjecie">Zdjęcie:</label><br>
        <input type="text" id="zdjecie" name="zdjecie"><br>
        <input type="submit" name="submit_dodaj_produkt" value="Dodaj produkt">
    </form>';
}
function PobierzKategorie() {
    $conn = db_connect();
    $query = "SELECT * FROM category_list";
    $result = mysqli_query($conn, $query);

    $categories = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }

    mysqli_close($conn);

    return $categories;
}

function DodajProdukt() {
    $conn = db_connect();

    // Pobierz dane z formularza
    $tytul = mysqli_real_escape_string($conn, $_POST['tytul']);
    $opis = mysqli_real_escape_string($conn, $_POST['opis']);
    $data_utworzenia = date('Y-m-d');
    $data_modyfikacji = mysqli_real_escape_string($conn, $_POST['data_modyfikacji']);
    $data_wygasniecia = mysqli_real_escape_string($conn, $_POST['data_wygasniecia']);
    $cena_netto = mysqli_real_escape_string($conn, $_POST['cena_netto']);
    $podatek_vat = mysqli_real_escape_string($conn, $_POST['podatek_vat']);
    $ilosc = mysqli_real_escape_string($conn, $_POST['ilosc']);
    $status = (isset($_POST['status']) && $_POST['status'] == '1') ? 1 : 0;
    $kategoria = mysqli_real_escape_string($conn, $_POST['kategoria']);
    $gabaryt = mysqli_real_escape_string($conn, $_POST['gabaryt']);
    $zdjecie = mysqli_real_escape_string($conn, $_POST['zdjecie']);

    // Dodaj do bazy danych
    $query = "INSERT INTO product_list (tytul, opis, data_utworzenia, data_modyfikacji, data_wygasniecia, cena_netto, podatek_vat, ilosc, status, kategoria, gabaryt, zdjecie) VALUES ('$tytul', '$opis', '$data_utworzenia', '$data_modyfikacji', '$data_wygasniecia', '$cena_netto', '$podatek_vat', '$ilosc', '$status', '$kategoria', '$gabaryt', '$zdjecie')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Nowy produkt został dodany.";
        echo '<script>window.location.href = "produkt.php";</script>';
    } else {
        echo "Błąd podczas dodawania produktu: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}

function ObslugaEdycjiProduktu() {
    if (isset($_POST['submit_dodaj_produkt'])) {
        $conn = db_connect();

        // Pobierz dane z formularza
        $id = mysqli_real_escape_string($conn, $_POST['id_produktu']);
        $tytul = mysqli_real_escape_string($conn, $_POST['tytul']);
        $opis = mysqli_real_escape_string($conn, $_POST['opis']);
        $data_utworzenia = mysqli_real_escape_string($conn, $_POST['data_utworzenia']);
        $data_modyfikacji = date('Y-m-d');
        $data_wygasniecia = mysqli_real_escape_string($conn, $_POST['data_wygasniecia']);
        $cena_netto = isset($_POST['cena_netto']) ? mysqli_real_escape_string($conn, $_POST['cena_netto']) : null;
        $podatek_vat = isset($_POST['podatek_vat']) ? mysqli_real_escape_string($conn, $_POST['podatek_vat']) : null;
        $ilosc = isset($_POST['ilosc']) ? mysqli_real_escape_string($conn, $_POST['ilosc']) : null;
        $kategoria = isset($_POST['kategoria']) ? mysqli_real_escape_string($conn, $_POST['kategoria']) : null;
        $gabaryt = isset($_POST['gabaryt']) ? mysqli_real_escape_string($conn, $_POST['gabaryt']) : null;
        $zdjecie = isset($_POST['zdjecie']) ? mysqli_real_escape_string($conn, $_POST['zdjecie']) : null;
        $status = isset($_POST['status']) ? mysqli_real_escape_string($conn, $_POST['status']) : null;

        // Aktualizuj dane w bazie danych
        $query = "UPDATE product_list SET tytul='$tytul', opis='$opis', data_utworzenia='$data_utworzenia', data_modyfikacji='$data_modyfikacji', data_wygasniecia='$data_wygasniecia', cena_netto='$cena_netto', podatek_vat='$podatek_vat', ilosc='$ilosc', kategoria='$kategoria', gabaryt='$gabaryt', zdjecie='$zdjecie', status='$status' WHERE id=$id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Produkt został zaktualizowany.";
        } else {
            echo "Błąd podczas aktualizacji produktu: " . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}

function UsunProdukt($id) {
    $conn = db_connect();

    $id = mysqli_real_escape_string($conn, $id);

    $query = "DELETE FROM product_list WHERE id=$id LIMIT 1";
    $result = mysqli_query($conn, $query);

    mysqli_close($conn);

    return $result; // Zwracaj wynik operacji usunięcia

}

if (isset($_GET['delete_product_id'])) {
    $delete_product_id = $_GET['delete_product_id'];
    $deleteSuccess = UsunProdukt($delete_product_id);
    
    if ($deleteSuccess) {
        header("Location: produkt.php?delete_success=true");
        exit();
    } else {
        echo "Błąd podczas usuwania produktu.";
    }
}

if (isset($_GET['delete_success']) && $_GET['delete_success'] == 'true') {
    echo "Produkt został usunięty.";
}


function ListaProduktow() {
    $conn = db_connect();
    $query = "SELECT * FROM product_list";
    $result = mysqli_query($conn, $query);

    echo '<table border="1">';
    echo '<tr>
            <th>ID</th>
            <th>Tytuł</th>
            <th>Opis</th>
            <th>Data Utworzenia</th>
            <th>Data Modyfikacji</th>
            <th>Data Wygaśnięcia</th>
            <th>Cena Netto</th>
            <th>Podatek VAT</th>
            <th>Ilość</th>
            <th>Status</th>
            <th>Kategoria</th>
            <th>Gabaryt</th>
            <th>Zdjęcie</th>
            <th>Akcje</th>
          </tr>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['tytul'] . '</td>';
        echo '<td>' . $row['opis'] . '</td>';
        echo '<td>' . $row['data_utworzenia'] . '</td>';
        echo '<td>' . $row['data_modyfikacji'] . '</td>';
        echo '<td>' . $row['data_wygasniecia'] . '</td>';
        echo '<td>' . $row['cena_netto'] . '</td>';
        echo '<td>' . $row['podatek_vat'] . '</td>';
        echo '<td>' . $row['ilosc'] . '</td>';
        echo '<td>' . ($row['status'] == 1 ? 'Aktywny' : 'Nieaktywny') . '</td>';
        $categoryName = PobierzNazweKategorii($row['kategoria']);
        echo '<td>' . $categoryName . '</td>';
        echo '<td>' . $row['gabaryt'] . '</td>';
        echo '<td><img src="' . $row['zdjecie'] . '" alt="Zdjęcie produktu" style="max-width: 100px; max-height: 100px;"></td>';
        echo '<td>
                <a href="produkt.php?edit_product_id=' . $row['id'] . '">Edytuj</a>
                <a href="produkt.php?delete_product_id=' . $row['id'] . '" onclick="return confirm(\'Czy na pewno chcesz usunąć ten produkt?\')">Usuń</a>
              </td>';
        echo '</tr>';
    }

    echo '</table>';
    mysqli_close($conn);
}
function PobierzNazweKategorii($kategoriaId) {
    $conn = db_connect();
    $query = "SELECT nazwa FROM category_list WHERE id = $kategoriaId";
    $result = mysqli_query($conn, $query);

    $categoryName = '';
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $categoryName = $row['nazwa'];
    }

    mysqli_close($conn);

    return $categoryName;
}

function EdytujProdukt($id) {
    $conn = db_connect();

    // Pobierz dane produktu z bazy danych
    $query = "SELECT * FROM product_list WHERE id=$id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Wyświetl formularz edycji z danymi produktu
        echo '
        <form action="produkt.php" method="post" style="text-align: left">
            <input type="hidden" name="id_produktu" value="' . $row['id'] . '">
            <label for="tytul">Tytuł:</label><br>
            <input type="text" id="tytul" name="tytul" value="' . $row['tytul'] . '"><br>
            <label for="opis">Opis:</label><br>
            <textarea id="opis" name="opis">' . $row['opis'] . '</textarea><br>
            <label for="data_utworzenia">Data utworzenia:</label><br>
            <input type="text" id="data_utworzenia" name="data_utworzenia" value="' . $row['data_utworzenia'] . '"><br>
            <label for="data_modyfikacji">Data modyfikacji:</label><br>
            <input type="text" id="data_modyfikacji" name="data_modyfikacji" value="' . $row['data_modyfikacji'] . '"><br>
            <label for="data_wygasniecia">Data wygaśnięcia:</label><br>
            <input type="text" id="data_wygasniecia" name="data_wygasniecia" value="' . $row['data_wygasniecia'] . '"><br>
            <label for="cena_netto">Cena netto:</label><br>
            <input type="text" id="cena_netto" name="cena_netto" value="' . $row['cena_netto'] . '"><br>
            <label for="podatek_vat">Podatek VAT:</label><br>
            <input type="text" id="podatek_vat" name="podatek_vat" value="' . $row['podatek_vat'] . '"><br>
            <label for="ilosc">Ilość:</label><br>
            <input type="text" id="ilosc" name="ilosc" value="' . $row['ilosc'] . '"><br>
            <label for="status">Status:</label><br>
            <input type="checkbox" id="status" name="status" value="1" ' . ($row['status'] ? 'checked' : '') . '><br>
            <label for="kategoria">Kategoria:</label><br>
            <select id="kategoria" name="kategoria">';
            $categories = PobierzKategorie();
            foreach ($categories as $category) {
                echo '<option value="' . $category['id'] . '">' . $category['nazwa'] . '</option>';
            }
            echo '</select><br>';
            echo '
            <label for="gabaryt">Gabaryt:</label><br>
            <input type="text" id="gabaryt" name="gabaryt" value="' . $row['gabaryt'] . '"><br>
            <label for="zdjecie">Zdjęcie (URL):</label><br>
            <input type="url" id="zdjecie" name="zdjecie" value="' . $row['zdjecie'] . '"><br>
            <input type="submit" name="submit_dodaj_produkt" value="Zapisz zmiany">
        </form>';
    } else {
        echo "Błąd podczas pobierania danych produktu: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}


if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true) {
    PokazPanelAdminaProduktu();
} else {
    echo FormularzLogowania();
    echo '<p><a href="contact.php">Skontaktuj się z nami</a></p> <p><a href="contact.php?action=przypomnijhaslo">Przypomnij hasło</a></p>';
}
if (isset($_GET['logout'])) {
    Wyloguj();
}

function Wyloguj() {
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    session_unset();
    session_destroy();

    // header("Location: admin.php");
    echo '<script>window.location.href = "admin.php";</script>';
    exit();
}


//KOSZYK

// Funkcja dodająca produkt do koszyka
function addToCart($productId, $quantity) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
        $_SESSION['count'] = 1;
    }

    // Sprawdź, czy podane ID produktu jest liczbą całkowitą
    if (is_numeric($productId) && intval($productId) > 0) {
        // Sprawdź, czy produkt o podanym ID istnieje w bazie danych
        if (productExists($productId)) {
            // Sprawdź, czy produkt już istnieje w koszyku
            foreach ($_SESSION['cart'] as $item) {
                if (is_array($item) && array_key_exists('id', $item) && $item['id'] == $productId) {
                    echo '<p>Produkt o podanym ID jest już w koszyku.</p>';
                    return;
                }
            }

            $nr = $_SESSION['count'];

            $prod = array(
                'id' => $productId,
                'ilosc' => $quantity,
                'data' => time()
            );

            $_SESSION['cart'][$nr] = $prod;
            $_SESSION['count']++;
        } else {
            echo '<p>Produkt o podanym ID nie istnieje w bazie danych.</p>';
        }
    } else {
        echo '<p>Nieprawidłowe ID produktu.</p>';
    }
}

// Funkcja sprawdzająca, czy produkt o podanym ID istnieje w bazie danych
function productExists($productId) {
    $conn = db_connect();

    $productId = mysqli_real_escape_string($conn, $productId);
    $query = "SELECT * FROM product_list WHERE id = $productId";
    $result = mysqli_query($conn, $query);

    mysqli_close($conn);

    return (mysqli_num_rows($result) > 0);
}

// Funkcja usuwająca produkt z koszyka
function removeFromCart($productId) {
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if (is_array($item) && array_key_exists('id', $item) && $item['id'] == $productId) {
                // Usuń przedmiot z koszyka
                unset($_SESSION['cart'][$key]);
                $_SESSION['count']--;

                // Sprawdź czy koszyk jest pusty po usunięciu przedmiotu
                if (empty($_SESSION['cart'])) {
                    echo '<p>Koszyk jest pusty.</p>';
                } else {
                    // Jeśli koszyk nie jest pusty, przekieruj na stronę produktu
                    echo '<script>window.location.href = "produkt.php";</script>';
                }
                return; // Zakończ funkcję po usunięciu przedmiotu
            }
        }
    } else {
        echo '<p>Koszyk jest pusty.</p>';
    }
}


// Funkcja wyświetlająca zawartość koszyka
function showCart() {
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        echo '<h2>Twój koszyk</h2>';
        echo '<ul>';
        $cenaBrutto = 0; 

        foreach ($_SESSION['cart'] as $item) {
            // Sprawdź, czy przedmiot nadal istnieje (nie został usunięty)
            if (is_array($item) && array_key_exists('id', $item) && array_key_exists('ilosc', $item) && array_key_exists('data', $item)) {
                $cenaBrutto = calculateBruttoPrice($item['id'], $item['ilosc']);
                echo '<li>';
                echo 'Produkt ID: ' . $item['id'] . ' | Ilość: ' . $item['ilosc'];
                echo ' | Cena brutto: ' . $cenaBrutto;
                echo ' | Data dodania: ' . date('Y-m-d H:i:s', $item['data']);
                echo ' | <a href="?remove=' . $item['id'] . '">Usuń</a>';
                echo ' | <a href="?edit=' . $item['id'] . '">Edytuj ilość</a>';
                echo '</li>';
            } else {
                // Pominięcie przedmiotów, które zostały usunięte
                continue;
            }
        }

        echo '</ul>';
    } else {
        echo '<p>Koszyk jest pusty.</p>';
    }
}


// Obsługa dodawania produktu do koszyka
if (isset($_POST['submit_add_to_cart'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    addToCart($productId, $quantity);
}

// Obsługa usuwania produktu z koszyka
if (isset($_GET['remove'])) {
    $productIdToRemove = $_GET['remove'];
    removeFromCart($productIdToRemove);
}
// Funkcja aktualizująca ilość produktu w koszyku
function updateQuantity($productId, $newQuantity) {
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as &$item) {
            if (is_array($item) && array_key_exists('id', $item) && $item['id'] == $productId) {
                $item['ilosc'] = $newQuantity;
                return true;
            }
        }
    }
    return false;
}

// Obsługa aktualizacji ilości produktu w koszyku
if (isset($_POST['submit_update_quantity'])) {
    $productIdToUpdate = $_POST['product_id'];
    $newQuantity = $_POST['new_quantity'];

    // Sprawdź, czy nowa ilość jest liczbą całkowitą większą od zera
    if (is_numeric($newQuantity) && intval($newQuantity) > 0) {
        updateQuantity($productIdToUpdate, $newQuantity);
        echo '<script>window.location.href = "produkt.php";</script>';
    } else {
        echo '<p>Nieprawidłowa ilość produktu.</p>';
    }
}

// Formularz aktualizacji ilości produktu w koszyku
if (isset($_GET['edit'])) {
    $productIdToEdit = $_GET['edit'];
    echo '<form action="" method="post">';
    echo '<input type="hidden" name="product_id" value="' . $productIdToEdit . '">';
    echo '<label for="new_quantity">Nowa ilość:</label>';
    echo '<input type="number" name="new_quantity" required>';
    echo '<input type="submit" name="submit_update_quantity" value="Aktualizuj ilość">';
    echo '</form>';
}
function calculateBruttoPrice($productId, $quantity) {
    $conn = db_connect();

    $productId = mysqli_real_escape_string($conn, $productId);
    $query = "SELECT cena_netto, podatek_vat FROM product_list WHERE id = $productId";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $cenaNetto = $row['cena_netto'];
        $podatekVat = $row['podatek_vat'];

        // Oblicz cenę brutto
        $cenaBrutto = ($cenaNetto + ($cenaNetto * $podatekVat / 100)) * $quantity;

        mysqli_close($conn);

        return $cenaBrutto;
    } else {
        mysqli_close($conn);
        return 0;
    }
}
?>

<!-- Formularz dodawania produktu do koszyka -->
<form action="" method="post">
    <label for="product_id">ID Produktu:</label>
    <input type="text" name="product_id" required><br>

    <label for="quantity">Ilość:</label>
    <input type="number" name="quantity" required><br>

    <input type="submit" name="submit_add_to_cart" value="Dodaj do koszyka">
</form>
<?php
// Wyświetlanie koszyka
showCart();
?>