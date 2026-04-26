<?php
session_start();

require_once 'includes/db.php';
require_once 'includes/functions.php';

$products = getProducts($pdo);
initializeCart($products);

$cartItems = getCartItems($products, $_SESSION['cart']);
$totals = calculateTotals($cartItems);

require_once 'includes/header.php';
?>

<h2>Your Shopping Cart</h2>

<?php if (empty($cartItems)): ?>
    <div class="message">
        <p>Your cart is currently empty.</p>
        <a class="link-button" href="index.php">Continue Shopping</a>
    </div>
<?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Quantity Ordered</th>
                    <th>Product Cost Individual</th>
                    <th>Product Total</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>$<?php echo number_format($item['cost'], 2); ?></td>
                        <td>$<?php echo number_format($item['total'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="totals-card">
        <h3>Order Summary</h3>

        <p><strong>Total of Items Ordered:</strong> $<?php echo number_format($totals['subtotal'], 2); ?></p>
        <p><strong>Tax 5%:</strong> $<?php echo number_format($totals['tax'], 2); ?></p>
        <p><strong>Shipping and Handling 10%:</strong> $<?php echo number_format($totals['shipping'], 2); ?></p>
        <p class="grand-total"><strong>Order Total:</strong> $<?php echo number_format($totals['grand_total'], 2); ?></p>

        <div class="cart-buttons">
            <a class="link-button secondary-link" href="index.php">Continue Shopping</a>
            <a class="link-button" href="checkout.php">Check Out</a>
        </div>
    </div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
