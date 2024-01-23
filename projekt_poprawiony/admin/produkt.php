<?php
include_once '../cfg.php';

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

session_start();

$productManager = new ProductManager();

if (isset($_POST['submit_dodaj_produkt'])) {
    if (isset($_POST['id_produktu'])) {
        $productManager->handleProductEdit();
    } else {
        $productManager->addProduct();
    }
}

if (isset($_GET['delete_product_id'])) {
    $delete_product_id = $_GET['delete_product_id'];
    $deleteSuccess = $productManager->deleteProduct($delete_product_id);

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

if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true) {
    $productManager->showAdminPanel();
} else {
    echo '<p>Nie jesteś zalogowany. Możesz się zalogować używając odpowiednich formularzy.</p>';
    echo '<p><a href="contact.php">Skontaktuj się z nami</a></p> <p><a href="contact.php?action=przypomnijhaslo">Przypomnij hasło</a></p>';
}

if (isset($_GET['logout'])) {
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    session_unset();
    session_destroy();
    echo '<script>window.location.href = "admin.php";</script>';
    exit();
}
echo '<link rel="stylesheet" href="../css/style.css">';
?>
<script>
    function toggleAddProductForm() {
        var addProductForm = document.getElementById('addProductForm');
        if (addProductForm.classList.contains('hidden')) {
            addProductForm.classList.remove('hidden');
        } else {
            addProductForm.classList.add('hidden');
        }
    }
</script>
<script>
$(document).ready(function() {
    $('.addToCartButton').on('click', function() {
        var productId = $(this).data('product-id');
        var quantity = $('#quantity').val();

        $.ajax({
            type: 'POST',
            url: 'produkt.php',
            data: { productId: productId, quantity: quantity },
            success: function() {
            },
            error: function() {
                alert('Wystąpił błąd podczas komunikacji z serwerem.');
            }
        });
    });
});
</script>


</script>
<?php

class ProductManager {
    // funckja do dodawania produktow
    public function addProduct() {
        $conn = db_connect();
    
        $tytul = mysqli_real_escape_string($conn, $_POST['tytul']);
        $opis = mysqli_real_escape_string($conn, $_POST['opis']);
        $data_utworzenia = date('Y-m-d');
        $data_modyfikacji = mysqli_real_escape_string($conn, $_POST['data_modyfikacji']);
        $data_wygasniecia = isset($_POST['data_wygasniecia']) ? mysqli_real_escape_string($conn, $_POST['data_wygasniecia']) : null;
        $cena_netto = isset($_POST['cena_netto']) ? mysqli_real_escape_string($conn, $_POST['cena_netto']) : null;
        $podatek_vat = isset($_POST['podatek_vat']) ? mysqli_real_escape_string($conn, $_POST['podatek_vat']) : null;
        $ilosc = isset($_POST['ilosc']) ? mysqli_real_escape_string($conn, $_POST['ilosc']) : null;
        $status = isset($_POST['status']) ? 1 : 0;
        $kategoria = isset($_POST['kategoria']) ? mysqli_real_escape_string($conn, $_POST['kategoria']) : null;
        $gabaryt = isset($_POST['gabaryt']) ? mysqli_real_escape_string($conn, $_POST['gabaryt']) : null;
        $zdjecie = isset($_POST['zdjecie']) ? mysqli_real_escape_string($conn, $_POST['zdjecie']) : null;
    
        $query = "INSERT INTO product_list (tytul, opis, data_utworzenia, data_modyfikacji, data_wygasniecia, cena_netto, podatek_vat, ilosc, status, kategoria, gabaryt, zdjecie) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
    
        if (isset($_FILES['zdjecie']) && $_FILES['zdjecie']['error'] == 0) {
            $image_tmp = $_FILES['zdjecie']['tmp_name'];
            $zdjecie = 'zdjecia/' . uniqid('image_') . '_' . $_FILES['zdjecie']['name'];
            move_uploaded_file($image_tmp, $zdjecie);
        }
    
        mysqli_stmt_bind_param($stmt, "ssssssssssss", $tytul, $opis, $data_utworzenia, $data_modyfikacji, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc, $status, $kategoria, $gabaryt, $zdjecie);
        $result = mysqli_stmt_execute($stmt);
    
        if ($result) {
            echo "Nowy produkt został dodany.";
            echo '<script>window.location.href = "produkt.php";</script>';
        } else {
            echo "Błąd podczas dodawania produktu: " . mysqli_error($conn);
        }
    
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    // funckja do usuwania produktow
    public function deleteProduct($id) {
        $conn = db_connect();

        $id = mysqli_real_escape_string($conn, $id);

        $query = "DELETE FROM product_list WHERE id=$id LIMIT 1";
        $result = mysqli_query($conn, $query);

        mysqli_close($conn);

        return $result;
    }

    public function showAdminPanel() {
        echo "<h1>Panel Administratora Produktu</h1>";
        echo '<p><a href="?logout">Wyloguj</a></p>';
        echo '<p><a href="admin.php">Powrót do Panelu Admina</a></p>';
        echo '<div>';
        $this->listProducts();
        echo '</div>';
    
        if (isset($_GET['edit_product_id'])) {
            $edit_product_id = $_GET['edit_product_id'];
            $this->editProduct($edit_product_id);
        } else {
            echo '<div style="float: left; margin-right: 20px;">';
            echo '<button onclick="toggleAddProductForm()">Dodaj Nowy Produkt</button>';
            echo '<form id="addProductForm" action="produkt.php" method="post" enctype="multipart/form-data" style="text-align: left" class="hidden">';
            echo '<label for="tytul">Tytuł:</label><br>';
            echo '<input type="text" id="tytul" name="tytul"><br>';
            echo '<label for="opis">Opis:</label><br>';
            echo '<textarea id="opis" name="opis"></textarea><br>';
            echo '<label for="data_utworzenia">Data utworzenia:</label><br>';
            echo '<input type="text" id="data_utworzenia" name="data_utworzenia" value="' . date('Y-m-d') . '"><br>';
            echo '<label for="data_modyfikacji">Data modyfikacji:</label><br>';
            echo '<input type="text" id="data_modyfikacji" name="data_modyfikacji" value="' . date('Y-m-d') . '"><br>';
            echo '<label for="data_wygasniecia">Data wygaśnięcia:</label><br>';
            echo '<input type="text" id="data_wygasniecia" name="data_wygasniecia"><br>';
            echo '<label for="cena_netto">Cena netto:</label><br>';
            echo '<input type="text" id="cena_netto" name="cena_netto"><br>';
            echo '<label for="podatek_vat">Podatek VAT:</label><br>';
            echo '<input type="text" id="podatek_vat" name="podatek_vat"><br>';
            echo '<label for="ilosc">Ilość:</label><br>';
            echo '<input type="text" id="ilosc" name="ilosc"><br>';
            echo '<label for="status">Status:</label><br>';
            echo '<input type="checkbox" id="status" name="status" value="1"><br>';
            echo '<label for="kategoria">Kategoria:</label><br>';
            echo '<select id="kategoria" name="kategoria">';
            $categories = $this->getCategories();
            foreach ($categories as $category) {
                echo '<option value="' . $category['id'] . '">' . $category['nazwa'] . '</option>';
            }
            echo '</select><br>';
            echo '<label for="gabaryt">Gabaryt:</label><br>';
            echo '<input type="text" id="gabaryt" name="gabaryt"><br>';
            echo '<label for="zdjecie">Zdjęcie:</label><br>';
            echo '<input type="file" id="zdjecie" name="zdjecie"><br>';
            echo '<input type="submit" name="submit_dodaj_produkt" value="Dodaj produkt">';
            echo '</form>';
            echo '</div>';
        }
    }
    
    public function listProducts() {
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
            $categoryName = ($row['kategoria'] !== '') ? $this->getCategoryName($row['kategoria']) : 'Brak kategorii';
            echo '<td>' . $categoryName . '</td>';
            echo '<td>' . $row['gabaryt'] . '</td>';
            echo '<td><img src="' . $row['zdjecie'] . '" alt="Zdjęcie produktu" style="max-width: 100px; max-height: 100px;"></td>';
            echo '<td>
                    <a href="produkt.php?edit_product_id=' . $row['id'] . '">Edytuj</a>
                    <a href="produkt.php?delete_product_id=' . $row['id'] . '" onclick="return confirm(\'Czy na pewno chcesz usunąć ten produkt?\')">Usuń</a>
                  </td>';
            echo '<td>
                <form method="post" action="produkt.php?add=' . $row['id'] . '">
                <input type="number" name="quantity" value="1" min="1" style="width: 40px;">
                <input type="submit" value="Dodaj do koszyka">
                </form>
                  </td>';
            echo '</tr>';
        }
    
        echo '</table>';
        mysqli_close($conn);
    }
    
    // funckja do przekazywania nazwy kategorii
    public function getCategoryName($kategoriaId) {
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
    
    // funkcja do pobierania kategorii
    public function getCategories() {
        $conn = db_connect();
        $query = "SELECT * FROM category_list";
        $result = mysqli_query($conn, $query);
    
        $categories = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }
    
        mysqli_close($conn);
    
        var_dump($categories);
        return $categories;
    }
    
    // funckja do edytowania przedmiotow
    public function editProduct($id) {
            $conn = db_connect();
        
            $query = "SELECT * FROM product_list WHERE id=$id";
            $result = mysqli_query($conn, $query);
        
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
        
                echo '
                <form action="produkt.php" method="post" enctype="multipart/form-data" style="text-align: left">
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
                    <input type="checkbox" id="status" name="status" value="1" ' . ($row['status'] == 1 ? 'checked' : '') . '><br>
                    <label for="kategoria">Kategoria:</label><br>
                    <select id="kategoria" name="kategoria">';
                    $categories = $this->getCategories();
                    foreach ($categories as $category) {
                        $selected = ($row['kategoria'] == $category['id']) ? 'selected' : '';
                        echo '<option value="' . $category['id'] . '" ' . $selected . '>' . $category['nazwa'] . '</option>';
                    }
                echo '</select><br>
                    <label for="gabaryt">Gabaryt:</label><br>
                    <input type="text" id="gabaryt" name="gabaryt" value="' . $row['gabaryt'] . '"><br>
                    <label for="zdjecie">Zdjęcie:</label><br>
                    <input type="file" id="zdjecie" name="zdjecie"><br>
                    <input type="submit" name="submit_dodaj_produkt" value="Zapisz zmiany">
                    <input type="button" value="Anuluj" onclick="location.href=\'produkt.php\';" style="margin-left: 10px;">
                </form>';
                }else {
                echo "Błąd podczas pobierania danych produktu: " . mysqli_error($conn);
            }
        
        mysqli_close($conn);
    }
    // funckja obslugujaca edycje produktow
    public function handleProductEdit() {
        if (isset($_POST['submit_dodaj_produkt'])) {
            $conn = db_connect();
    
            // Pobierz dane z formularza
            $id = mysqli_real_escape_string($conn, $_POST['id_produktu']);
            $tytul = mysqli_real_escape_string($conn, $_POST['tytul']);
            $opis = mysqli_real_escape_string($conn, $_POST['opis']);
            $data_utworzenia = isset($_POST['data_utworzenia']) ? mysqli_real_escape_string($conn, $_POST['data_utworzenia']) : null;
            $data_modyfikacji = date('Y-m-d');
            $data_wygasniecia = isset($_POST['data_wygasniecia']) ? mysqli_real_escape_string($conn, $_POST['data_wygasniecia']) : null;
            $cena_netto = isset($_POST['cena_netto']) ? mysqli_real_escape_string($conn, $_POST['cena_netto']) : null;
            $podatek_vat = isset($_POST['podatek_vat']) ? mysqli_real_escape_string($conn, $_POST['podatek_vat']) : null;
            $ilosc = isset($_POST['ilosc']) ? mysqli_real_escape_string($conn, $_POST['ilosc']) : null;
            $kategoria = isset($_POST['kategoria']) ? mysqli_real_escape_string($conn, $_POST['kategoria']) : null;
            $gabaryt = isset($_POST['gabaryt']) ? mysqli_real_escape_string($conn, $_POST['gabaryt']) : null;
            $status = isset($_POST['status']) ? mysqli_real_escape_string($conn, $_POST['status']) : null;
            $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

            if (isset($_FILES['zdjecie']) && $_FILES['zdjecie']['error'] == 0) {
                $image_tmp = $_FILES['zdjecie']['tmp_name'];
                $zdjecie = 'zdjecia/' . uniqid('image_') . '_' . $_FILES['zdjecie']['name'];
                if (move_uploaded_file($image_tmp, $zdjecie)) {
                    echo 'Plik został przeniesiony do folderu zdjecia.';
                } else {
                    echo 'Błąd podczas przenoszenia pliku: ' . $_FILES['zdjecie']['error'];
                }
            }

            if (isset($_POST['submit_dodaj_produkt'])) {
                if (isset($_POST['quantity']) && is_numeric($_POST['quantity']) && intval($_POST['quantity']) > 0) {
                    $quantity = intval($_POST['quantity']);
            
                    if ($quantity > $ilosc) {
                        echo "Błąd: Wybrana ilość przekracza dostępną ilość produktu.";
                    } else {
                    }
                }
            }
    
            $query = "UPDATE product_list SET tytul=?, opis=?, data_utworzenia=?, data_modyfikacji=?, data_wygasniecia=?, cena_netto=?, podatek_vat=?, ilosc=?, kategoria=?, gabaryt=?, zdjecie=?, status=? WHERE id=?";
            $stmt = mysqli_prepare($conn, $query);
    
            mysqli_stmt_bind_param($stmt, "ssssssssssssi", $tytul, $opis, $data_utworzenia, $data_modyfikacji, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc, $kategoria, $gabaryt, $zdjecie, $status, $id);
            $result = mysqli_stmt_execute($stmt);
    
            if ($result) {
                echo "Produkt został zaktualizowany.";
            } else {
                echo "Błąd podczas aktualizacji produktu: " . mysqli_error($conn);
            }
    
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
    }

    // funkcja do ustawienia ilosci produktow
    public function getProductQuantity($productId) {
        $conn = db_connect();
        $productId = mysqli_real_escape_string($conn, $productId);
        $query = "SELECT ilosc FROM product_list WHERE id = $productId";
        $result = mysqli_query($conn, $query);

        if ($row = mysqli_fetch_assoc($result)) {
            $quantity = $row['ilosc'];
        } else {
            $quantity = 0;
        }

        mysqli_close($conn);

        return $quantity;
    }

    // funkcja do zmieniania ilosci produktow
    public function updateProductQuantity($productId, $newQuantity) {
        $conn = db_connect();
    
        $productId = mysqli_real_escape_string($conn, $productId);
        $newQuantity = mysqli_real_escape_string($conn, $newQuantity);
    
        $query = "UPDATE product_list SET ilosc = '$newQuantity' WHERE id = '$productId'";
    
        if (mysqli_query($conn, $query)) {
            echo '<p>Pomyślnie zaktualizowano ilość produktu.</p>';
        } else {
            echo '<p>Błąd w zapytaniu SQL: ' . mysqli_error($conn) . '</p>';
        }
    
        mysqli_close($conn);
    }
    
    
}

class CartManager {
    // Funkcja dodająca produkt do koszyka
    public static function addToCart($productId, $quantity) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
            $_SESSION['count'] = 1;
        }
        if (is_numeric($productId) && intval($productId) > 0) {
            if (self::productExists($productId)) {
                foreach ($_SESSION['cart'] as $item) {
                    if (is_array($item) && array_key_exists('id', $item) && $item['id'] == $productId) {
                        echo '<p>Produkt o podanym ID jest już w koszyku.</p>';
                        return;
                    }
                }

                $productManager = new ProductManager();
                $availableQuantity = $productManager->getProductQuantity($productId);

                if ($quantity <= $availableQuantity) {
                    $nr = $_SESSION['count'];

                $prod = array(
                    'id' => $productId,
                    'ilosc' => $quantity,
                    'data' => time()
                );

                $_SESSION['cart'][$nr] = $prod;
                $_SESSION['count']++;
                $productManager->updateProductQuantity($productId, $availableQuantity - $quantity);
                echo '<script>window.location.href = "produkt.php"</script>';
            }
                else {
                    echo '<p>Ilość w koszyku przekracza dostępną ilość produktu.</p>';
                }
            } else {
                echo '<p>Produkt o podanym ID nie istnieje w bazie danych.</p>';
            }
        } else {
            echo '<p>Nieprawidłowe ID produktu.</p>';
        }
    }

    // Funkcja sprawdzająca, czy produkt o podanym ID istnieje w bazie danych
    public static function updateQuantity($productId, $newQuantity) {
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as &$item) {
                if (is_array($item) && array_key_exists('id', $item) && $item['id'] == $productId) {
                    $oldQuantity = $item['ilosc'];
                    $productManager = new ProductManager();
                    $availableQuantity = $productManager->getProductQuantity($productId);

                    if ($newQuantity > $availableQuantity) {
                        echo '<p>Ilość w koszyku przekracza dostępną ilość produktu.</p>';
                        return 0;
                    }

                    $quantityDiff = $newQuantity - $oldQuantity;

                    if ($availableQuantity < $quantityDiff) {
                        echo '<p>Różnica ilości przekracza dostępną ilość produktu w magazynie.</p>';
                        return 0;
                    }
                    $productManager->updateProductQuantity($productId, $availableQuantity - $quantityDiff);
                    $item['ilosc'] = $newQuantity;
                    $newQuantity = $availableQuantity - $quantityDiff;

                    echo '<script>window.location.href = "produkt.php";</script>';
                    return $newQuantity;
                }
            }
        }
        return 0;
    }

    // Funkcja usuwająca produkt z koszyka
    public static function removeFromCart($productId) {
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $item) {
                if (is_array($item) && array_key_exists('id', $item) && $item['id'] == $productId) {
                    $productManager = new ProductManager();
                    $availableQuantity = $productManager->getProductQuantity($productId);
                    $productManager->updateProductQuantity($productId, $availableQuantity + $item['ilosc']);
                    unset($_SESSION['cart'][$key]);
                    $_SESSION['count']--;
                    if (empty($_SESSION['cart'])) {
                        echo '<p>Koszyk jest pusty.</p>';
                        echo '<script>window.location.href = "produkt.php"</script>';
                    } else {
                        echo '<script>window.location.href = "produkt.php";</script>';
                    }
                    
                    return;
                }
            }
        } else {
            echo '<p>Koszyk jest pusty.</p>';
        }
    }
    // Funkcja wyświetlająca zawartość koszyka
    public static function showCart() {
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            echo '<h2>Twój koszyk</h2>';
            echo '<ul>';
            $cenaBrutto = 0; 

            foreach ($_SESSION['cart'] as $item) {
                if (is_array($item) && array_key_exists('id', $item) && array_key_exists('ilosc', $item) && array_key_exists('data', $item)) {
                    $cenaBrutto = self::calculateBruttoPrice($item['id'], $item['ilosc']);
                    echo '<li>';
                    echo 'Produkt ID: ' . $item['id'] . ' | Ilość: ' . $item['ilosc'];
                    echo ' | Cena brutto: ' . $cenaBrutto;
                    echo ' | Data dodania: ' . date('Y-m-d H:i:s', $item['data']);
                    echo ' | <a href="?remove=' . $item['id'] . '">Usuń</a>';
                    echo ' | <form method="post" action="?edit=' . $item['id'] . '">';
                    echo '    <label for="quantity">Nowa ilość:</label>';
                    echo '    <input type="number" id="quantity" name="quantity" min="1" value="' . $item['ilosc'] . '">';
                    echo '    <button type="submit">Zaktualizuj ilość</button>';
                    echo '</form>';
                    echo '</li>';
                } else {
                    continue;
                }
            }
            
            echo '</ul>';
        } else {
            echo '<p>Koszyk jest pusty.</p>';
        }
    }

    // Funkcja obliczająca cenę brutto produktu
    private static function calculateBruttoPrice($productId, $quantity) {
        $conn = db_connect();

        $productId = mysqli_real_escape_string($conn, $productId);
        $query = "SELECT cena_netto, podatek_vat FROM product_list WHERE id = $productId";
        $result = mysqli_query($conn, $query);

        if ($row = mysqli_fetch_assoc($result)) {
            $cenaNetto = $row['cena_netto'];
            $podatekVat = $row['podatek_vat'];
            $cenaBrutto = $cenaNetto * (1 + ($podatekVat / 100)) * $quantity;
        } else {
            $cenaBrutto = 0;
        }

        mysqli_close($conn);

        return $cenaBrutto;
    }

    // funckja sprawdzajaca czy produkt istnieje
    private static function productExists($productId) {
        $conn = db_connect();

        $productId = mysqli_real_escape_string($conn, $productId);
        $query = "SELECT * FROM product_list WHERE id = $productId";
        $result = mysqli_query($conn, $query);

        mysqli_close($conn);

        return (mysqli_num_rows($result) > 0);
    }
}
// Obsługa dodawania produktu do koszyka
if (isset($_GET['add'])) {
    $productId = $_GET['add'];
    $quantity = $_POST['quantity'];
    CartManager::addToCart($productId, $quantity);
}

// Obsługa usuwania produktu z koszyka
if (isset($_GET['remove'])) {
    $productId = $_GET['remove'];
    CartManager::removeFromCart($productId);
}

// Obsługa aktualizacji ilości produktu w koszyku
if (isset($_GET['edit'])) {
    $productId = $_GET['edit'];

    if (isset($_POST['quantity'])) {
        $newQuantity = $_POST['quantity'];
        $quantityDiff = CartManager::updateQuantity($productId, $newQuantity);

        if ($quantityDiff !== 0) {
            $productManager = new ProductManager();
            $productManager->updateProductQuantity($productId, $quantityDiff);
        }
    } else {
        echo "Błąd: Brak klucza 'quantity' w tablicy \$_POST";
    }
}

// Wyświetlenie zawartości koszyka
CartManager::showCart();
?>


    


