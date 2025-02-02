<?php
require_once(__DIR__ . '/../includes/database.php');

function getProducts($category = null, $search = null, $pageNumber = 1, $productsPerPage = 15) {
    $db = getDatabaseConnection();
    $offset = ($pageNumber - 1) * $productsPerPage;

    $sql = "SELECT id, name, category_id, description, 
        CONCAT('/CODA_PROJET/mvc/uploads/', image) AS image, 
        price, promo_price, promo_end, stock
        FROM product WHERE 1";


    if (!empty($category)) {
        $sql .= " AND category_id = :category";
    }
    if (!empty($search)) {
        $sql .= " AND name LIKE :search";
    }
    $sql .= " LIMIT :offset, :limit";

    $query = $db->prepare($sql);
    
    if (!empty($category)) {
        $query->bindParam(':category', $category, PDO::PARAM_INT);
    }
    if (!empty($search)) {
        $search = '%' . $search . '%';
        $query->bindParam(':search', $search, PDO::PARAM_STR);
    }
    $query->bindParam(':offset', $offset, PDO::PARAM_INT);
    $query->bindParam(':limit', $productsPerPage, PDO::PARAM_INT);

    $query->execute();

    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function getTotalPages($category = null, $search = null, $productsPerPage = 15) {
    $db = getDatabaseConnection();

    $sql = "SELECT COUNT(*) FROM product WHERE 1";
    if (!empty($category)) {
        $sql .= " AND category_id = :category";
    }
    if (!empty($search)) {
        $sql .= " AND name LIKE :search";
    }

    $query = $db->prepare($sql);
    
    if (!empty($category)) {
        $query->bindParam(':category', $category, PDO::PARAM_INT);
    }
    if (!empty($search)) {
        $search = '%' . $search . '%';
        $query->bindParam(':search', $search, PDO::PARAM_STR);
    }

    $query->execute();
    $totalProducts = $query->fetchColumn();

    return ceil($totalProducts / $productsPerPage);
}
?>
