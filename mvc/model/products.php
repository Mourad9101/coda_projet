<?php

function getAllProducts(PDO $pdo): array | string
{
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT id, category_id, name, description, image, price, promo_price, promo_end, stock, 
                     CASE 
                        WHEN promo_price IS NOT NULL AND promo_end >= CURDATE() THEN promo_price 
                        ELSE price 
                     END AS final_price
              FROM product";
    
    $prep = $pdo->prepare($query);

    try {
        $prep->execute();
    } catch (PDOException $e) {
        return "Erreur : " . $e->getCode() . " : " . $e->getMessage();
    }

    return $prep->fetchAll(PDO::FETCH_ASSOC);
}

function getAllProductsWithPromotions(PDO $pdo): array | string
{
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "
        SELECT 
            p.id, p.name, p.category_id, p.description, p.image, p.price, 
            p.promo_price, p.promo_end, p.stock,
            CASE 
                WHEN p.promo_price IS NOT NULL AND p.promo_end >= CURDATE() THEN p.promo_price
                ELSE p.price
            END AS final_price,
            (p.promo_price IS NOT NULL AND p.promo_end >= CURDATE()) AS is_promo,
            c.name AS category
        FROM product p
        LEFT JOIN category c ON p.category_id = c.id
    ";
    
    $stmt = $pdo->prepare($query);

    try {
        $stmt->execute();
    } catch (PDOException $e) {
        return "Erreur : " . $e->getCode() . " : " . $e->getMessage();
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function insertProduct(PDO $pdo, string $name, int $categoryId, string $description, float $price, int $stock, ?string $image, ?float $promoPrice = null, ?string $promoEnd = null): bool | string
{
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "INSERT INTO product (name, category_id, description, price, stock, image, promo_price, promo_end) 
              VALUES (:name, :category_id, :description, :price, :stock, :image, :promo_price, :promo_end)";
    $prep = $pdo->prepare($query);
    
    $prep->bindValue(':name', $name);
    $prep->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
    $prep->bindValue(':description', $description);
    $prep->bindValue(':price', $price);
    $prep->bindValue(':stock', $stock, PDO::PARAM_INT);
    $prep->bindValue(':image', $image);
    $prep->bindValue(':promo_price', $promoPrice !== null ? $promoPrice : null, PDO::PARAM_NULL | PDO::PARAM_STR);
    $prep->bindValue(':promo_end', $promoEnd !== null ? $promoEnd : null, PDO::PARAM_NULL | PDO::PARAM_STR);

    try {
        $prep->execute();
    } catch (PDOException $e) {
        return "Erreur : " . $e->getCode() . " : " . $e->getMessage();
    }

    return true;
}

function updateProduct(PDO $pdo, int $id, string $name, int $categoryId, string $description, float $price, int $stock, ?string $image, ?float $promoPrice = null, ?string $promoEnd = null): bool | string
{
    $query = "UPDATE product 
              SET name = :name, category_id = :category_id, description = :description, 
                  price = :price, stock = :stock, image = :image, promo_price = :promo_price, promo_end = :promo_end 
              WHERE id = :id";
    $prep = $pdo->prepare($query);
    
    $prep->bindValue(':id', $id, PDO::PARAM_INT);
    $prep->bindValue(':name', $name);
    $prep->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
    $prep->bindValue(':description', $description);
    $prep->bindValue(':price', $price);
    $prep->bindValue(':stock', $stock, PDO::PARAM_INT);
    $prep->bindValue(':image', $image);
    $prep->bindValue(':promo_price', $promoPrice !== null ? $promoPrice : null, PDO::PARAM_NULL | PDO::PARAM_STR);
    $prep->bindValue(':promo_end', $promoEnd !== null ? $promoEnd : null, PDO::PARAM_NULL | PDO::PARAM_STR);

    try {
        $prep->execute();
    } catch (PDOException $e) {
        return "Erreur : " . $e->getCode() . " : " . $e->getMessage();
    }

    return true;
}

function deleteProduct(PDO $pdo, int $id): bool | string
{
    $query = "DELETE FROM product WHERE id = :id";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':id', $id, PDO::PARAM_INT);

    try {
        $prep->execute();
        return true;
    } catch (PDOException $e) {
        return "Erreur lors de la suppression : " . $e->getMessage();
    }
}

function getProductsByCategory(PDO $pdo, int $categoryId): array
{
    $query = "SELECT p.id, p.name, p.description, p.image, p.price, p.promo_price, p.promo_end, p.stock, c.name AS category,
                     CASE 
                        WHEN p.promo_price IS NOT NULL AND p.promo_end >= CURDATE() THEN p.promo_price 
                        ELSE p.price 
                     END AS final_price
              FROM product p
              LEFT JOIN category c ON p.category_id = c.id
              WHERE p.category_id = :category_id";
              
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function resetImage(PDO $pdo, int $id): bool
{
    $query = "UPDATE product SET image = NULL WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    try {
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        return "Erreur lors de la réinitialisation de l'image : " . $e->getMessage();
    }
}

?>
