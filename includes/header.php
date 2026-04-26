<?php
$cartCount = 0;

if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $quantity) {
        $cartCount += (int) $quantity;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bright Market</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container header-flex">
            <div>
                <h1>Bright Market</h1>
                <p class="tagline">Simple PHP and MySQL Shopping Cart Store</p>
            </div>

            <nav>
                <a href="index.php">Catalog</a>
                <a href="cart.php">Cart (<?php echo $cartCount; ?>)</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <?php if (!empty($_SESSION['message'])): ?>
            <div class="flash-message">
                <?php
                    echo htmlspecialchars($_SESSION['message']);
                    unset($_SESSION['message']);
                ?>
            </div>
        <?php endif; ?>
