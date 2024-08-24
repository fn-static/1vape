<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Sprawdzenie, czy użytkownik już istnieje
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        echo "Ten email jest już zarejestrowany.";
    } else {
        // Dodanie użytkownika do bazy danych
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $email, $password])) {
            echo "Rejestracja zakończona sukcesem!";
        } else {
            echo "Błąd podczas rejestracji.";
        }
    }
}
?>
