<?php
class Product
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllProducts(): array
    {
        $sql = 'SELECT product_id, product_name, product_description, product_cost FROM products ORDER BY product_id';
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function productExists(int $productId): bool
    {
        $sql = 'SELECT COUNT(*) FROM products WHERE product_id = :product_id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':product_id' => $productId]);
        return $stmt->fetchColumn() > 0;
    }
}
