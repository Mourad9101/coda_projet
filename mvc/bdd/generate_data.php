<?php
require_once 'vendor/autoload.php';

$faker = \Faker\Factory::create();

try {
    $pdo = new PDO('mysql:host=localhost;dbname=ecommerce_db', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
    exit();
}

for ($i = 0; $i < 10; $i++) {
    $name = $faker->userName;
    $password = password_hash('password123', PASSWORD_BCRYPT);
    $role = $faker->randomElement(['admin', 'editor']);

    $stmt = $pdo->prepare("INSERT INTO users (name, password, role) VALUES (?, ?, ?)");
    $stmt->execute([$name, $password, $role]);

    echo "Utilisateur créé : $name avec le rôle $role\n";
}

echo "Données générées avec succès!";
