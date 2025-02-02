<?php
session_start();
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../model/categories.php';

$pdo = getDatabaseConnection();
$categories = getCategories($pdo);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique - Catalogue | MyShop</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(to right, #1e1e1e, #2c2c2c);
            font-family: 'Poppins', sans-serif;
            color: #e0e0e0;
        }

        .navbar {
            background-color: #181818;
            padding: 12px 0;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 24px;
            color: #ffcc00 !important;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #ffcc00 !important;
        }

        .hero-banner {
            background: url('https://source.unsplash.com/1600x600/?shopping,ecommerce') center/cover no-repeat;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            font-weight: bold;
            font-size: 2.5rem;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.6);
            flex-direction: column;
        }

        .hero-banner .cta-btn {
            background: linear-gradient(135deg, #ffcc00, #ff8800);
            color: #222;
            font-weight: bold;
            padding: 10px 20px;
            font-size: 18px;
            margin-top: 15px;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
        }

        .hero-banner .cta-btn:hover {
            background: linear-gradient(135deg, #ff8800, #ffcc00);
            color: white;
        }

        .promo-banner {
            background-color: #ffcc00;
            text-align: center;
            padding: 10px;
            font-weight: bold;
            font-size: 18px;
            color: #222;
            margin-bottom: 20px;
        }

        /* 🌟 Catégories modernisées */
        .category-link {
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: bold;
            cursor: pointer;
            background: linear-gradient(135deg, #8e44ad, #3498db);
            color: white;
            transition: all 0.3s ease-in-out;
            display: inline-block;
            text-align: center;
            font-size: 16px;
        }

        .category-link:hover {
            background: linear-gradient(135deg, #3498db, #8e44ad);
            transform: translateY(-3px);
            box-shadow: 0px 4px 10px rgba(255, 255, 255, 0.2);
        }

        .product-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            overflow: hidden;
            text-align: center;
            padding: 15px;
        }

        .product-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            transition: transform 0.3s ease-in-out;
            border-radius: 10px;
        }

        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.4);
        }

        .footer {
            background: #181818;
            padding: 20px;
            text-align: center;
            margin-top: 40px;
            color: white;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">MyShop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Catalogue</a></li>
                    <li class="nav-item"><a class="nav-link" href="panier.php">Panier <span id="cart-count" class="badge bg-warning">0</span></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-banner">
        <div>🛍️ Bienvenue sur MyShop - Trouvez vos articles préférés !</div>
        <a href="#catalog-container" class="cta-btn">🎁 Voir les Offres</a>
    </section>

    <div class="promo-banner">🔥 GRANDES SOLDES D'HIVER - Jusqu'à -50% sur tout le catalogue ! 🚀</div>

    <main class="container my-5">
        <h1 class="text-center mb-4">Découvrez Nos Produits</h1>

        <!-- Liste des catégories dynamiques -->
        <div id="categories-container" class="d-flex flex-wrap gap-3 mb-4">
            <?php foreach ($categories as $category): ?>
                <span class="category-link" data-id="<?= htmlspecialchars($category['id']) ?>">
                    <?= htmlspecialchars($category['name']) ?>
                </span>
            <?php endforeach; ?>
        </div>

        <div id="catalog-container" class="row"></div>
        <div id="pagination-container" class="mt-4"></div>
    </main>

    <footer class="footer">
        <p>© 2024 MyShop - Tous droits réservés.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="../../assets/main.js"></script>
    <script type="module" src="../../assets/components/cart.js"></script>
</body>
</html>
