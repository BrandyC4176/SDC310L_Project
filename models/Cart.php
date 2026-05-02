<?php
class Cart
{
    public function initialize(array $products): void
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

    public function add(int $productId): void
    {
        if (!isset($_SESSION['cart'][$productId])) $_SESSION['cart'][$productId] = 0;
        $_SESSION['cart'][$productId]++;
    }

    public function remove(int $productId): void
    {
        if (!isset($_SESSION['cart'][$productId])) $_SESSION['cart'][$productId] = 0;
        $_SESSION['cart'][$productId]--;
        if ($_SESSION['cart'][$productId] < 0) $_SESSION['cart'][$productId] = 0;
    }

    public function update(int $productId, int $quantity): void
    {
        $_SESSION['cart'][$productId] = max(0, $quantity);
    }

    public function clear(): void
    {
        $_SESSION['cart'] = [];
    }

    public function countItems(): int
    {
        $count = 0;
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $quantity) $count += (int) $quantity;
        }
        return $count;
    }

    public function getItems(array $products): array
    {
        $items = [];
        foreach ($products as $product) {
            $id = (int) $product['product_id'];
            if (isset($_SESSION['cart'][$id]) && $_SESSION['cart'][$id] > 0) {
                $quantity = (int) $_SESSION['cart'][$id];
                $cost = (float) $product['product_cost'];
                $items[] = [
                    'id' => $id,
                    'name' => $product['product_name'],
                    'quantity' => $quantity,
                    'cost' => $cost,
                    'total' => $quantity * $cost
                ];
            }
        }
        return $items;
    }

    public function calculateTotals(array $cartItems): array
    {
        $subtotal = 0;
        foreach ($cartItems as $item) $subtotal += $item['total'];
        $tax = $subtotal * 0.05;
        $shipping = $subtotal * 0.10;
        return [
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'grand_total' => $subtotal + $tax + $shipping
        ];
    }
}
