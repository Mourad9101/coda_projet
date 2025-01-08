<?php
require 'includes/database.php';

$pdo = getDatabaseConnection();

if ($pdo) {
    echo "Connexion réussie à la base de données.";
} else {
    echo "Échec de la connexion.";
}
?>
