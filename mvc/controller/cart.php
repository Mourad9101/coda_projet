<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"), true);

if ($method === 'POST') {
    $productId = $input['productId'] ?? null;

    if (!$productId) {
        echo json_encode(["success" => false, "message" => "ID du produit manquant."]);
        exit;
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $_SESSION['cart'][$productId] = ($_SESSION['cart'][$productId] ?? 0) + 1;

    session_write_close();
    echo json_encode(["success" => true, "cartCount" => array_sum($_SESSION['cart'])]);
    exit;
}

if ($method === 'GET' && !isset($_GET['action'])) {
    $cartItems = [];

    if (!empty($_SESSION['cart'])) {
        require_once('../includes/database.php');
        $db = getDatabaseConnection();

        $productIds = array_keys($_SESSION['cart']);
        $placeholders = implode(',', array_fill(0, count($productIds), '?'));

        $query = $db->prepare("SELECT id, name, description, image, price FROM product WHERE id IN ($placeholders)");
        $query->execute($productIds);
        $products = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($products as $product) {
            $product['quantity'] = $_SESSION['cart'][$product['id']];
            $cartItems[] = $product;
        }
    }

    session_write_close();
    echo json_encode(["cartItems" => $cartItems, "cartCount" => array_sum($_SESSION['cart'] ?? [])]);
    exit;
}

if ($method === 'DELETE') {
    $productId = $input['productId'] ?? null;

    if (!$productId || !isset($_SESSION['cart'][$productId])) {
        echo json_encode(["success" => false, "message" => "Produit non trouvé dans le panier."]);
        exit;
    }

    unset($_SESSION['cart'][$productId]);

    session_write_close();
    echo json_encode(["success" => true, "cartCount" => array_sum($_SESSION['cart'] ?? [])]);
    exit;
}

if ($method === 'GET' && isset($_GET['action']) && $_GET['action'] === 'clear') {
    unset($_SESSION['cart']);
    
    session_write_close();
    echo json_encode(["success" => true, "cartCount" => 0]);
    exit;
}

if ($method === 'PUT') {
    $productId = $input['productId'] ?? null;
    $change = $input['change'] ?? 0;

    if (!$productId || !isset($_SESSION['cart'][$productId])) {
        echo json_encode(["success" => false, "message" => "Produit non trouvé dans le panier."]);
        exit;
    }

    $_SESSION['cart'][$productId] += $change;

    if ($_SESSION['cart'][$productId] <= 0) {
        unset($_SESSION['cart'][$productId]);
    }

    session_write_close();
    echo json_encode(["success" => true, "cartCount" => array_sum($_SESSION['cart'] ?? [])]);
    exit;
}
