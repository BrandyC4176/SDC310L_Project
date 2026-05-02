<?php require __DIR__ . '/../layout/header.php'; ?>
<h2>Product Catalog</h2>
<p class="intro">Welcome to Bright Market. This Week 4 version uses an MVC-style structure.</p>
<div class="table-wrap">
<table>
<thead><tr><th>Product ID</th><th>Product Name</th><th>Product Description</th><th>Product Cost</th><th>Quantity Currently in Cart</th><th>Actions</th></tr></thead>
<tbody>
<?php foreach ($products as $product): ?>
    <?php $id = (int) $product['product_id']; ?>
    <tr>
        <td><?php echo $id; ?></td>
        <td><?php echo htmlspecialchars($product['product_name']); ?></td>
        <td><?php echo htmlspecialchars($product['product_description']); ?></td>
        <td>$<?php echo number_format($product['product_cost'], 2); ?></td>
        <td><?php echo $_SESSION['cart'][$id] ?? 0; ?></td>
        <td><div class="actions">
            <form method="post"><input type="hidden" name="product_id" value="<?php echo $id; ?>"><input type="hidden" name="action" value="add"><button type="submit">Add</button></form>
            <form method="post"><input type="hidden" name="product_id" value="<?php echo $id; ?>"><input type="hidden" name="action" value="remove"><button type="submit" class="secondary">Remove</button></form>
            <form method="post" class="inline-form"><input type="hidden" name="product_id" value="<?php echo $id; ?>"><input type="hidden" name="action" value="update"><input type="number" name="quantity" min="0" value="<?php echo $_SESSION['cart'][$id] ?? 0; ?>"><button type="submit" class="dark">Update</button></form>
        </div></td>
    </tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
