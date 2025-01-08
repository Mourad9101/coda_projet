<?php
function getDatabaseConnection() {
    $host = 'localhost';
    $dbname = 'ecommerce_db';
    $username = 'root'; // Remplacez par votre nom d'utilisateur MySQL
    $password = 'root'; // Remplacez par votre mot de passe MySQL

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}
?>