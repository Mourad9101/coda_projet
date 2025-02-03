<?php
require 'vendor/autoload.php';
require 'includes/database.php'; // Fichier contenant la connexion à la DB

$faker = Faker\Factory::create();
$conn = new PDO("mysql:host=localhost;dbname=ecommerce_db;charset=utf8", "root", "");

function seedUsers($conn, $faker, $count = 10) {
    $roles = ['admin', 'editor'];

    for ($i = 0; $i < $count; $i++) {
        $username = $faker->userName;
        $email = $faker->email;
        $password = password_hash('password', PASSWORD_BCRYPT);
        $role = $roles[array_rand($roles)];

        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $email, $password, $role]);
    }
}

function seedCategories($conn, $faker, $count = 5) {
    for ($i = 0; $i < $count; $i++) {
        $name = ucfirst($faker->word);

        $stmt = $conn->prepare("INSERT INTO category (name) VALUES (?)");
        $stmt->execute([$name]);
    }
}

function seedProducts($conn, $faker, $count = 20) {
    $categories = $conn->query("SELECT id FROM category")->fetchAll(PDO::FETCH_COLUMN);

    if (empty($categories)) {
        echo "Ajoute d'abord des catégories avant d'insérer des produits.\n";
        return;
    }

    for ($i = 0; $i < $count; $i++) {
        $name = ucfirst($faker->words(2, true));
        $category_id = $categories[array_rand($categories)];
        $description = $faker->sentence(10);
        $image = "https://picsum.photos/200/300";
        $price = $faker->randomFloat(2, 5, 500);
        $stock = $faker->numberBetween(1, 100);

        if (rand(1, 5) === 1) { 
            $promo_price = $price * 0.8;
            $promo_end = $faker->dateTimeBetween('now', '+1 month')->format('Y-m-d');
        } else {
            $promo_price = null;
            $promo_end = null;
        }

        $stmt = $conn->prepare("INSERT INTO product (name, category_id, description, image, price, stock, promo_price, promo_end) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $category_id, $description, $image, $price, $stock, $promo_price, $promo_end]);
    }
}

seedUsers($conn, $faker);
seedCategories($conn, $faker);
seedProducts($conn, $faker);

echo "Les données ont été générées avec succès ! 🎉\n";
?>
