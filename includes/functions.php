<?php

function getProducts(PDO $pdo): array
{
    $sql = 'SELECT product_id, product_name, product_description, product_cost
            FROM products
            ORDER BY product_id';

    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function productExists(array $products, int $productId): bool
{
    foreach ($products as $product) {
        if ((int) $product['product_id'] === $productId) {
            return true;
        }
    }

    return false;
}

function initializeCart(array $products): void
{
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    foreach ($products as $product) {
        $id = (int) $product['product_id'];

        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = 0;
        }
    }
}

function getCartItems(array $products, array $cart): array
{
    $items = [];

    foreach ($products as $product) {
        $id = (int) $product['product_id'];

        if (isset($cart[$id]) && $cart[$id] > 0) {
            $quantity = (int) $cart[$id];
            $cost = (float) $product['product_cost'];
            $lineTotal = $quantity * $cost;

            $items[] = [
                'id' => $id,
                'name' => $product['product_name'],
                'quantity' => $quantity,
                'cost' => $cost,
                'total' => $lineTotal
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
        'grand_total' => $grandTotal
    ];
}

function saveOrder(PDO $pdo, array $cartItems, array $totals): int
{
    $orderSql = 'INSERT INTO orders (subtotal, tax, shipping, order_total)
                 VALUES (:subtotal, :tax, :shipping, :order_total)';

    $orderStmt = $pdo->prepare($orderSql);

    $orderStmt->execute([
        ':subtotal' => $totals['subtotal'],
        ':tax' => $totals['tax'],
        ':shipping' => $totals['shipping'],
        ':order_total' => $totals['grand_total']
    ]);

    $orderId = (int) $pdo->lastInsertId();

    $itemSql = 'INSERT INTO order_items 
                (order_id, product_id, quantity, product_cost, line_total)
                VALUES
                (:order_id, :product_id, :quantity, :product_cost, :line_total)';

    $itemStmt = $pdo->prepare($itemSql);

    foreach ($cartItems as $item) {
        $itemStmt->execute([
            ':order_id' => $orderId,
            ':product_id' => $item['id'],
            ':quantity' => $item['quantity'],
            ':product_cost' => $item['cost'],
            ':line_total' => $item['total']
        ]);
    }

    return $orderId;
}
