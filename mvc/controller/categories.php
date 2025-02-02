<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../model/categories.php';

$pdo = getDatabaseConnection(); // ✅ Récupérer la connexion PDO
$categories = getCategories($pdo); // ✅ Passer PDO à la fonction

require_once __DIR__ . '/../view/categories.php';
?>
