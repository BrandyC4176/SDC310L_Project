<?php
session_start();
require_once __DIR__ . '/../controllers/CatalogController.php';
$controller = new CatalogController();
$controller->index();
