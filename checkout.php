<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Musisz być zalogowany, aby złożyć zamówienie.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $total_amount = 0;

    // Pobierz dane użytkownika
    $stmt = $pdo->prepare("SELECT email, username FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    // Oblicz kwotę zamówienia
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $stmt = $pdo->prepare("SELECT name, price FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();
        $total_amount += $product['price'] * $quantity;
        $order_items[] = [
            'name' => $product['name'],
            'quantity' => $quantity,
            'price' => $product['price']
        ];
    }

    // Utworzenie zamówienia w bazie danych
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount) VALUES (?, ?)");
    $stmt->execute([$user_id, $total_amount]);
    $order_id = $pdo->lastInsertId();

    // Dodanie produktów do zamówienia
    foreach ($order_items as $item) {
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$order_id, $item['product_id'], $item['quantity']]);
    }

    // Wyczyść koszyk
    unset($_SESSION['cart']);

    // Przygotowanie wiadomości e-mail
    $to_customer = $user['email'];
    $to_owner = 'owner@yourshop.com'; // Wpisz tutaj swój adres e-mail
    $subject = "Potwierdzenie zamówienia nr $order_id";
    $headers = "From: sklep@example.com"; // Wpisz swój adres e-mail nadawcy

    $message = "Dziękujemy za złożenie zamówienia!\n\n";
    $message .= "Szczegóły zamówienia:\n";
    foreach ($order_items as $item) {
        $message .= $item['name'] . " x " . $item['quantity'] . " = " . $item['price'] * $item['quantity'] . " zł\n";
    }
    $message .= "\nŁączna kwota: " . $total_amount . " zł\n";

    // Wysłanie e-maila do klienta
    if (mail($to_customer, $subject, $message, $headers)) {
        echo "Potwierdzenie zamówienia wysłane na e-mail klienta.";
    } else {
        echo "Nie udało się wysłać e-maila z potwierdzeniem.";
    }

    // Wysłanie e-maila do właściciela sklepu
    mail($to_owner, $subject, $message, $headers);

    echo "Zamówienie zostało złożone!";
}
?>
