<?php
// Funkcja: PokazKontakt
// Opis: Generuje formularz kontaktowy do wyświetlenia na stronie.
// Zwraca: Wygenerowany formularz HTML.
function PokazKontakt()
{
    $formularz = '
    <div id="formularz-kontaktowy">
        <h2>Formularz Kontaktowy</h2>
        <form method="post" action="contact.php?action=wyslij">
            <label for="temat">Temat:</label>
            <input type="text" name="temat" id="temat" required><br>

            <label for="tresc">Treść wiadomości:</label>
            <textarea name="tresc" id="tresc" rows="4" required></textarea><br>

            <label for="email">Twój adres e-mail:</label>
            <input type="email" name="email" id="email" required><br>

            <input type="submit" value="Wyślij wiadomość">
        </form>
    </div>';

    echo $formularz;
}

// Funkcja: WyslijMailKontakt
// Opis: Wysyła e-mail z formularza kontaktowego.
// Parametry:
//   - $odbiorca: Adres e-mail odbiorcy.
function WyslijMailKontakt($odbiorca)
{
    if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email'])) {
        echo '[nie_wypelniles_pola]';
        PokazKontakt();
    } else {
        $mail['subject'] = $_POST['temat'];
        $mail['body'] = $_POST['tresc'];
        $mail['sender'] = $_POST['email'];
        $mail['recipient'] = $odbiorca;

        $header = "From: Formularz kontaktowy <" . $mail['sender'] . ">\n";
        $header .= "MIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\nContent-Transfer-Encoding:\n";
        $header .= "X-Sender: <" . $mail['sender'] . ">\n";
        $header .= "X-Mailer: PRapwww mail 1.2\n";
        $header .= "X-Priority: 3\n";
        $header .= "Return-Path: <" . $mail['sender'] . ">\n";

        mail($mail['recipient'], $mail['subject'], $mail['body'], $header);

        echo '[wiadomosc_wyslana]';
    }
}

// Funkcja: PrzypomnijHaslo
// Opis: Wyświetla formularz do przypomnienia hasła lub wysyła e-mail z hasłem.
// Zwraca: Wygenerowany formularz HTML lub informację o wysłaniu hasła.
function PrzypomnijHaslo() {
    // Wczytaj login i hasło z pliku cfg.php
    include('../cfg.php');

    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        if (empty($email) || $email !== $login) {
            echo '[niepoprawny_email]';
            // Wyświetl formularz przypomnienia hasła
            echo PokazPrzypomnienieHasla();
        } else {
            $mail['subject'] = 'Przypomnienie hasła';
            $mail['body'] = 'Twoje hasło: ' . $pass;
            $mail['sender'] = '164340@student.uwm.edu.pl'; // Możesz dostosować nadawcę
            $mail['recipient'] = $email;

            $header = "From: Przypomnienie hasła <" . $mail['sender'] . ">\n";
            $header .= "MIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\nContent-Transfer-Encoding:\n";
            $header .= "X-Sender: <" . $mail['sender'] . ">\n";
            $header .= "X-Mailer: PRapWWW mail 1.2\n";
            $header .= "X-Priority: 3\n";
            $header .= "Return-Path: <" . $mail['sender'] . ">\n";

            // Wysłanie maila
            mail($mail['recipient'], $mail['subject'], $mail['body'], $header);

            echo '[przypomnienie_wysłane]  ';
            echo $pass; // Możesz zdecydować się wyświetlić hasło na stronie
        }
    } else {
        // Wyświetl formularz przypomnienia hasła
        echo PokazPrzypomnienieHasla();
    }
}

function PokazPrzypomnienieHasla() {
    $form = '
    <h2>Przypomnij Hasło</h2>
    <form method="post" action="' . $_SERVER['REQUEST_URI'] . '">
        <label for="email">Email:</label>
        <input type="email" name="email"><br>

        <input type="submit" name="przypomnij_haslo" value="Przypomnij hasło">
    </form>
    ';

    return $form;
}


$action = isset($_GET['action']) ? $_GET['action'] : '';

// Wykonanie odpowiedniej akcji w zależności od parametru action
if ($action == 'wyslij') {
    WyslijMailKontakt('psiwek@przyklad.com');
} elseif ($action == 'przypomnijhaslo') {
    PrzypomnijHaslo();
} else {
    PokazKontakt();
}
?>
