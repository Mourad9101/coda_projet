<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../model/products.php';
require_once __DIR__ . '/../model/categories.php';

$pdo = getDatabaseConnection();
$categories = getCategories($pdo);

$selectedCategory = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;

if (!function_exists('getAllProductsWithPromotions') || !function_exists('getProductsByCategory')) {
    die('Erreur : Une fonction est introuvable dans products.php du modèle.');
}

if ($selectedCategory) {
    $products = getProductsByCategory($pdo, $selectedCategory); // 🔹 Correction ici
} else {
    $products = getAllProductsWithPromotions($pdo);
}

require_once __DIR__ . '/../view/products.php';
