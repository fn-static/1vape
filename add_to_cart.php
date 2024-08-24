<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Jeśli koszyk nie istnieje, tworzymy go
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Dodanie produktu do koszyka
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }

    echo "Produkt dodany do koszyka!";
}
?>
