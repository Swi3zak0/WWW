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

    return $formularz;
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
function PrzypomnijHaslo()
{
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $haslo = $_GET['haslo'];
        WyslijMailKontakt('admin@przyklad.com', 'Przypomnienie hasła', 'Twoje hasło to: ' . $haslo);
    } else {
        $formularz = '
        <div id="formularz-przypomnij-haslo">
            <h2>Przypomnienie hasła</h2>
            <form method="post" action="contact.php?action=przypomnijhaslo">
                <label for="email">Twój adres e-mail:</label>
                <input type="email" name="email" id="email" required><br>

                <input type="submit" value="Przypomnij hasło">
            </form>
        </div>';

        return $formularz;
    }
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

// Wykonanie odpowiedniej akcji w zależności od parametru action
if ($action == 'wyslij') {
    WyslijMailKontakt('adres_odbiorcy@przyklad.com');
} elseif ($action == 'przypomnijhaslo') {
    PrzypomnijHaslo();
} else {
    PokazKontakt();
}

?>