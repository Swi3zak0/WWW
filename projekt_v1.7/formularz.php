<?
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    echo "Dane od użytkownika:<br>";
    echo "Imię: $name<br>";
    echo "Email: $email<br>";
    echo "Wiadomość: $message<br>";
}
?>