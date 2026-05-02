<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Cart.php';

class CatalogController
{
    private Product $productModel;
    private Cart $cartModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();
        $this->productModel = new Product($db);
        $this->cartModel = new Cart();
    }

    public function index(): void
    {
        $products = $this->productModel->getAllProducts();
        $this->cartModel->initialize($products);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $this->handleCartAction();
        $cartCount = $this->cartModel->countItems();
        require __DIR__ . '/../views/catalog/index.php';
    }

    private function handleCartAction(): void
    {
        $productId = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;
        $action = $_POST['action'] ?? '';
        if (!$this->productModel->productExists($productId)) {
            header('Location: index.php'); exit;
        }
        if ($action === 'add') $this->cartModel->add($productId);
        if ($action === 'remove') $this->cartModel->remove($productId);
        if ($action === 'update') {
            $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 0;
            $this->cartModel->update($productId, $quantity);
        }
        header('Location: index.php'); exit;
    }
}
