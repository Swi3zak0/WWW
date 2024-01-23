<?php
include_once '../cfg.php';

class CMS {
    private $conn;

    public function __construct() {
        session_start();
        $this->conn = $this->db_connect();
    }
    // funkcja do obslugi zapytan
    public function handleRequest() {
        if (isset($_POST['submit_dodaj'])) {
            if (isset($_POST['id_podstrony'])) {
                $this->handleEditPage();
            } else {
                $this->addPage();
            }
        }

        if (isset($_POST['login_email']) && isset($_POST['login_pass'])) {
            $this->handleLogin();
        }

        if ($this->isLoggedIn()) {
            $this->showAdminPanel();
        } else {
            echo $this->renderLoginForm();
            echo '<p><a href="contact.php">Skontaktuj się z nami</a></p> <p><a href="contact.php?action=przypomnijhaslo">Przypomnij hasło</a></p>';
        }

        if (isset($_GET['logout'])) {
            $this->logout();
        }

        if (isset($_GET['delete_id'])) {
            $delete_id = $_GET['delete_id'];
            $this->deletePage($delete_id);
        }

        echo '<link rel="stylesheet" href="../css/style3.css">';
    }
    // funkcja do dodawania strony
    private function addPage() {
        $title = mysqli_real_escape_string($this->conn, $_POST['tytul']);
        $content = mysqli_real_escape_string($this->conn, $_POST['tresc']);
        $status = isset($_POST['status']) ? 1 : 0;

        $query = "INSERT INTO page_list (page_title, page_content, status) VALUES ('$title', '$content', $status)";
        mysqli_query($this->conn, $query);

        echo "Nowa podstrona została dodana.";
    }
    // funckja do obslugi edycji strony
    private function handleEditPage() {
        if (isset($_POST['submit_dodaj'])) {
            $id = mysqli_real_escape_string($this->conn, $_POST['id_podstrony']);
            $title = mysqli_real_escape_string($this->conn, $_POST['tytul']);
            $content = mysqli_real_escape_string($this->conn, $_POST['tresc']);
            $status = isset($_POST['status']) ? 1 : 0;

            $query = "UPDATE page_list SET page_title='$title', page_content='$content', status=$status WHERE id=$id";
            $result = mysqli_query($this->conn, $query);

            if ($result) {
                echo "Podstrona została zaktualizowana.";
            } else {
                echo "Błąd podczas aktualizacji podstrony: " . mysqli_error($this->conn);
            }
        }
    }
    // funkcja do usuwania strony
    private function deletePage($id) {
        $id = mysqli_real_escape_string($this->conn, $id);

        $query = "DELETE FROM page_list WHERE id=$id";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            echo "Podstrona została usunięta.";
            header("Location: admin.php");
            exit();
        } else {
            echo "Błąd podczas usuwania podstrony: " . mysqli_error($this->conn);
        }
    }
    // funkcja do generowania formulara do logowania
    private function renderLoginForm() {
        return '
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
    }
    // funkcja do wyswietlania panelu admina
    private function showAdminPanel() {
        echo "<h1>Panel Administratora</h1>";
        echo '<p><a href="?logout">Wyloguj</a></p>';
        $this->listPages();

        if (isset($_GET['edit_id'])) {
            $edit_id = $_GET['edit_id'];
            $this->editPage($edit_id);
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
    // funkcja do pobierania i wyswietlania liste stron
    private function listPages() {
        $query = "SELECT * FROM page_list ORDER BY id DESC LIMIT 100";
        $result = mysqli_query($this->conn, $query);

        echo '<div class="lista-podstron">';
        echo '<ul>';
        while ($row = mysqli_fetch_assoc($result)) {
            $id = htmlspecialchars($row['id']);
            $title = htmlspecialchars($row['page_title']);

            echo '<li>';
            echo "$id - Tytuł: $title ";
            echo "<a href='admin.php?edit_id=$id'>Edytuj</a> ";
            echo "<a href='admin.php?delete_id=$id' onclick='return confirm(\"Czy na pewno chcesz usunąć tę podstronę?\")'>Usuń</a>";
            echo '</li>';
        }
        echo '</ul>';
        echo '</div>';
    }
    // funckja do edycji strony
    private function editPage($id) {
        $podstrona = $this->getPage($id);

        if ($podstrona) {
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
    // funckja do pobierania strony
    private function getPage($id) {
        $id = mysqli_real_escape_string($this->conn, $id);

        $query = "SELECT * FROM page_list WHERE id = '$id' LIMIT 1";
        $result = mysqli_query($this->conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row;
        } else {
            return false;
        }
    }
    // funckja do sprawdzania czy jest zalogowany
    private function isLoggedIn() {
        return isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true;
    }
    // funkcja do obslugi logowania
    private function handleLogin() {
        global $login, $pass;

        if ($_POST['login_email'] == $login && $_POST['login_pass'] == $pass) {
            $_SESSION['zalogowany'] = true;
        } else {
            echo 'Błędny login lub hasło';
        }
    }
    // funckja do wylogowania
    private function logout() {
        session_unset();
        session_destroy();
        header("Location: admin.php");
        exit();
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
}

$cms = new CMS();
$cms->handleRequest();
?>
