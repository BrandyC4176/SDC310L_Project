<?php
session_start();

require_once 'includes/db.php';
require_once 'includes/functions.php';

$products = getProducts($pdo);
initializeCart($products);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;
    $action = $_POST['action'] ?? '';

    if (productExists($products, $productId)) {
        switch ($action) {
            case 'add':
                $_SESSION['cart'][$productId]++;
                break;

            case 'remove':
                $_SESSION['cart'][$productId]--;
                if ($_SESSION['cart'][$productId] < 0) {
                    $_SESSION['cart'][$productId] = 0;
                }
                break;

            case 'update':
                $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 0;
                $_SESSION['cart'][$productId] = max(0, $quantity);
                break;
        }
    }

    header('Location: index.php');
    exit;
}

require_once 'includes/header.php';
?>

<h2>Product Catalog</h2>
<p class="intro">Welcome to Bright Market, a simple online store built with PHP and MySQL.</p>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Product Description</th>
                <th>Product Cost</th>
                <th>Quantity Currently in Cart</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($products as $product): ?>
                <?php $id = (int) $product['product_id']; ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($product['product_description']); ?></td>
                    <td>$<?php echo number_format($product['product_cost'], 2); ?></td>
                    <td><?php echo $_SESSION['cart'][$id]; ?></td>
                    <td>
                        <div class="actions">
                            <form method="post">
                                <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                <input type="hidden" name="action" value="add">
                                <button type="submit">Add</button>
                            </form>

                            <form method="post">
                                <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                <input type="hidden" name="action" value="remove">
                                <button type="submit" class="secondary">Remove</button>
                            </form>

                            <form method="post" class="inline-form">
                                <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                <input type="hidden" name="action" value="update">
                                <input type="number" name="quantity" min="0" value="<?php echo $_SESSION['cart'][$id]; ?>">
                                <button type="submit" class="dark">Update</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once 'includes/footer.php'; ?>
