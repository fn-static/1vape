<?php
$host = 'localhost';
$dbname = 'sklep';
$username = 'root';  // Zmień na swoją nazwę użytkownika MySQL
$password = '';      // Zmień na swoje hasło do MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Połączenie nieudane: " . $e->getMessage());
}
?>
