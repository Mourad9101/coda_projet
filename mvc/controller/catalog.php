<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

require_once('../model/catalog.php');

$pageNumber = $_GET['page'] ?? 1;
$search = $_GET['search'] ?? null;
$category = $_GET['category'] ?? null;

$products = getProducts($category, $search, $pageNumber, 15);
$totalPages = getTotalPages($category, $search, 15);

if (empty($products)) {
    echo json_encode([
        "error" => "Aucun produit trouvé.",
        "products" => [],
        "totalPages" => 0
    ]);
    exit;
}

echo json_encode([
    "products" => array_map(function ($product) {
        $imagePath = !empty($product["image"]) ? "/CODA_PROJET/uploads/" . ltrim($product["image"], '/') : "/CODA_PROJET/assets/img/default.png";
        $today = date("Y-m-d");
        $isPromo = !empty($product["promo_price"]) && !empty($product["promo_end"]) && $product["promo_end"] >= $today;

        return [
            "id" => $product["id"],
            "name" => $product["name"],
            "category_id" => $product["category_id"],
            "description" => $product["description"],
            "image" => $imagePath,
            "price" => $product["price"],
            "promo_price" => $isPromo ? $product["promo_price"] : null,
            "promo_end" => $isPromo ? $product["promo_end"] : null,
            "stock" => $product["stock"]
        ];
    }, $products),
    "totalPages" => $totalPages
]);
exit;
