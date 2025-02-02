<?php

function getCategories(PDO $pdo): array
{
    $query = "SELECT id, name FROM category";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
