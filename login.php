<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Pobranie użytkownika z bazy danych
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Ustawienie sesji użytkownika
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        echo "Logowanie zakończone sukcesem!";
        header("Location: index.html");
        exit();
    } else {
        echo "Niepoprawny email lub hasło.";
    }
}
?>
