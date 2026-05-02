<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Order.php';

class CartController
{
    private Product $productModel;
    private Cart $cartModel;
    private Order $orderModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();
        $this->productModel = new Product($db);
        $this->cartModel = new Cart();
        $this->orderModel = new Order($db);
    }

    public function index(): void
    {
        $products = $this->productModel->getAllProducts();
        $this->cartModel->initialize($products);
        $cartItems = $this->cartModel->getItems($products);
        $totals = $this->cartModel->calculateTotals($cartItems);
        $cartCount = $this->cartModel->countItems();
        require __DIR__ . '/../views/cart/index.php';
    }

    public function checkout(): void
    {
        $products = $this->productModel->getAllProducts();
        $this->cartModel->initialize($products);
        $cartItems = $this->cartModel->getItems($products);
        $totals = $this->cartModel->calculateTotals($cartItems);
        if (!empty($cartItems)) {
            $this->orderModel->save($cartItems, $totals);
            $_SESSION['message'] = 'Checkout complete. Your order was saved and your cart has been cleared.';
        } else {
            $_SESSION['message'] = 'Your cart was empty, so no order was placed.';
        }
        $this->cartModel->clear();
        header('Location: index.php'); exit;
    }
}
