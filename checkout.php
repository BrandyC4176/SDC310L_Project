<?php
session_start();
$_SESSION['cart'] = [];
$_SESSION['message'] = 'Checkout complete. Your cart has been cleared.';
header('Location: index.php');
exit;
