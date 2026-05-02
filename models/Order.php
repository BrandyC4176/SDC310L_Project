<?php
class Order
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(array $cartItems, array $totals): int
    {
        $orderSql = 'INSERT INTO orders (subtotal, tax, shipping, order_total) VALUES (:subtotal, :tax, :shipping, :order_total)';
        $orderStmt = $this->db->prepare($orderSql);
        $orderStmt->execute([
            ':subtotal' => $totals['subtotal'],
            ':tax' => $totals['tax'],
            ':shipping' => $totals['shipping'],
            ':order_total' => $totals['grand_total']
        ]);
        $orderId = (int) $this->db->lastInsertId();

        $itemSql = 'INSERT INTO order_items (order_id, product_id, quantity, product_cost, line_total) VALUES (:order_id, :product_id, :quantity, :product_cost, :line_total)';
        $itemStmt = $this->db->prepare($itemSql);
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
}
