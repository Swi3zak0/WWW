<?php
echo '<link rel="stylesheet" href="../css/style2.css">';
class CategoryManager {
    private $conn;

    public function __construct() {
        include_once '../cfg.php';
        $this->conn = $this->db_connect();
        session_start();
    }
    // funckja do pobierania produktow z kategorii
    public function getProductsInCategory($categoryId) {
        $categoryId = mysqli_real_escape_string($this->conn, $categoryId);
    
        $query = "SELECT * FROM product_list WHERE kategoria = '$categoryId'";
        $result = mysqli_query($this->conn, $query);
    
        $products = array();
    
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    
        return $products;
    }
    
    // obsluga zapytan
    public function handleRequest() {
        if (isset($_POST['submit_dodaj_kategorie'])) {
            if (isset($_POST['id_kategorii'])) {
                $this->handleCategoryEdit();
            } else {
                $this->addCategory();
            }
        }

        if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true) {
            $this->showAdminPanel();
        } else {
            echo $this->loginForm() . '<p><a href="contact.php">Skontaktuj się z nami</a></p> <p><a href="contact.php?action=przypomnijhaslo">Przypomnij hasło</a></p>';
        }

        if (isset($_GET['logout'])) {
            $this->logout();
        }

        if (isset($_GET['delete_category'])) {
            $delete_category = $_GET['delete_category'];
            $this->deleteCategory($delete_category);
        }

        if (isset($_GET['show_category_products'])) {
            $categoryId = $_GET['show_category_products'];
            $this->displayProductsInCategory($categoryId);
        }
    }
    // funckja do dodawania kategorii
    public function addCategory() {
        $matka = mysqli_real_escape_string($this->conn, $_POST['matka']);
        $nazwa = mysqli_real_escape_string($this->conn, $_POST['nazwa']);

        $query = "INSERT INTO category_list (matka, nazwa) VALUES ('$matka', '$nazwa')";
        mysqli_query($this->conn, $query);

        echo "Nowa kategoria została dodana.";
    }
    // obsluga edycji kategorii
    public function handleCategoryEdit() {
        $id = mysqli_real_escape_string($this->conn, $_POST['id_kategorii']);
        $matka = mysqli_real_escape_string($this->conn, $_POST['matka']);
        $nazwa = mysqli_real_escape_string($this->conn, $_POST['nazwa']);

        $query = "UPDATE category_list SET matka='$matka', nazwa='$nazwa' WHERE id=$id";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            echo "Kategoria została zaktualizowana.";
        } else {
            echo "Błąd podczas aktualizacji kategorii: " . mysqli_error($this->conn);
        }
    }
    // funckja do usuwania kategorii
    public function deleteCategory($id) {
        $id = mysqli_real_escape_string($this->conn, $id);

        $query = "DELETE FROM category_list WHERE id=$id";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            echo "Kategoria została usunięta.";
            header("Location: sklep.php");
            exit();
        } else {
            echo "Błąd podczas usuwania kategorii: " . mysqli_error($this->conn);
        }
    }
    // funkcja do pokazywania panelu admina
    public function showAdminPanel() {
        echo "<h1>Panel Administratora Kategorii</h1>";
        echo '<p><a href="?logout">Wyloguj</a></p>';
        echo '<p><a href="admin.php">Powrót do Panelu Admina</a></p>';
        echo '<div>';
        $this->displayCategories();
        echo '</div>';
    
        if (isset($_GET['edit_category'])) {
            $edit_category = $_GET['edit_category'];
            $this->editCategory($edit_category);
        }
    
        echo '
        <form action="sklep.php" method="post" style="text-align: left">
            <label for="matka">Matka:</label><br>
            <input type="text" id="matka" name="matka"><br>
            <label for="nazwa">Nazwa:</label><br>
            <input type="text" id="nazwa" name="nazwa"><br>
            <input type="submit" name="submit_dodaj_kategorie" value="Dodaj kategorię">
        </form>';
    
        echo '<h2>Wybierz kategorię do wyświetlenia produktów:</h2>';
        $categories = $this->getCategories();
        foreach ($categories as $category) {
            echo '<a href="?show_category_products=' . $category['id'] . '">' . $category['nazwa'] . '</a><br>';
        }
    }
    // funkcja do pobierania kategorii
    public function getCategories() {
        $query = "SELECT * FROM category_list";
        $result = mysqli_query($this->conn, $query);
    
        $categories = array();
    
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }
    
        return $categories;
    }
    // funckja do wyswietlania produktow w kategorii
    public function displayProductsInCategory($categoryId) {
        $categoryId = mysqli_real_escape_string($this->conn, $categoryId);
    
        $query = "SELECT * FROM product_list WHERE kategoria = '$categoryId'";
        $result = mysqli_query($this->conn, $query);
    }
    
    
    // funckja do edycji kategorii
    public function editCategory($id) {
        $category = $this->getCategory($id);

        if ($category) {
            echo '<form action="sklep.php" method="post" style="text-align: left">';
            echo '<input type="hidden" name="id_kategorii" value="' . $id . '">';
            
            echo '<label for="matka">Matka:</label>';
            echo '<input type="text" name="matka" value="' . htmlspecialchars($category['matka']) . '"><br>';
            
            echo '<label for="nazwa">Nazwa:</label>';
            echo '<input type="text" name="nazwa" value="' . htmlspecialchars($category['nazwa']) . '"><br>';
            
            echo '<input type="submit" name="submit_dodaj_kategorie" value="Zapisz">';
            echo '</form>';
        } else {
            echo 'Kategoria o podanym identyfikatorze nie istnieje.';
        }
    }

    // funckja do wyswietlania kategorii
    public function displayCategories($parent = 0) {
        $query = "SELECT * FROM category_list WHERE matka = $parent ORDER BY id DESC"; 
        $result = mysqli_query($this->conn, $query);

        echo '<ul>';

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $nazwa = $row['nazwa'];

            echo '<li>';
            echo "ID: $id - Nazwa: $nazwa ";
            
            echo "<a href='sklep.php?edit_category=$id'>Edytuj</a> ";
            echo "<a href='sklep.php?delete_category=$id' onclick='return confirm(\"Czy na pewno chcesz usunąć tę kategorię?\")'>Usuń</a>";

            $this->displayCategories($id);

            echo '</li>';
        }

        echo '</ul>';
    }
    // funkcja do pobierania kategorii
    public function getCategory($id) {
        $id = mysqli_real_escape_string($this->conn, $id);

        $query = "SELECT * FROM category_list WHERE id = '$id' LIMIT 1";
        $result = mysqli_query($this->conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row;
        } else {
            return false;
        }
    }
    // funkcja do laczenia sie z baza danych
    public function db_connect() {
        include_once '../cfg.php';
        $conn = db_connect();
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        return $conn;
    }
    // funkcja do wylogowania
    public function logout() {
        session_unset();
        session_destroy();
        header("Location: admin.php");
        exit();
    }
}


$categoryManager = new CategoryManager();
$categoryManager->handleRequest();


if (isset($_GET['show_category_products'])) {
    $categoryId = $_GET['show_category_products'];
    $category = $categoryManager->getCategory($categoryId);

    if ($category) {
        $categoryName = $category['nazwa'];
        $products = $categoryManager->getProductsInCategory($categoryId);

        echo "<h2>Produkty w kategorii: $categoryName</h2>";

        foreach ($products as $product) {
            echo "ID: {$product['id']} - Nazwa: {$product['tytul']}<br>";
            // Dodaj inne informacje o produkcie, które chcesz wyświetlić
        }
    } else {
        echo "Nie znaleziono kategorii o podanym identyfikatorze.";
    }
}


?>
