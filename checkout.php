<?php
session_start();

require_once 'includes/db.php';
require_once 'includes/functions.php';

$products = getProducts($pdo);
initializeCart($products);

$cartItems = getCartItems($products, $_SESSION['cart']);
$totals = calculateTotals($cartItems);

if (!empty($cartItems)) {
    saveOrder($pdo, $cartItems, $totals);
    $_SESSION['message'] = 'Checkout complete. Your order was saved and your cart has been cleared.';
} else {
    $_SESSION['message'] = 'Your cart was empty, so no order was placed.';
}

$_SESSION['cart'] = [];

header('Location: index.php');
exit;
