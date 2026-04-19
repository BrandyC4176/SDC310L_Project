<?php
function initializeCart(array $products): void
{
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    foreach ($products as $id => $product) {
        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = 0;
        }
    }
}

function getCartItems(array $products, array $cart): array
{
    $items = [];

    foreach ($cart as $productId => $quantity) {
        if ($quantity > 0 && isset($products[$productId])) {
            $product = $products[$productId];
            $items[] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'quantity' => $quantity,
                'cost' => $product['cost'],
                'total' => $product['cost'] * $quantity
            ];
        }
    }

    return $items;
}

function calculateTotals(array $cartItems): array
{
    $subtotal = 0;

    foreach ($cartItems as $item) {
        $subtotal += $item['total'];
    }

    $tax = $subtotal * 0.05;
    $shipping = $subtotal * 0.10;
    $grandTotal = $subtotal + $tax + $shipping;

    return [
        'subtotal' => $subtotal,
        'tax' => $tax,
        'shipping' => $shipping,
        'grandTotal' => $grandTotal
    ];
}
