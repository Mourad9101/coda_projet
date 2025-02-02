<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Panier - MyShop</title>

    <!-- Google Fonts : Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icônes FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* 🌑 Arrière-plan modernisé */
        body {
            background: linear-gradient(to right, #1e1e1e, #2c2c2c);
            font-family: 'Poppins', sans-serif;
            color: #e0e0e0;
        }

        /* Barre de navigation */
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

        /* Bannière héroïque */
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

        /* Conteneur principal */
        .cart-container {
            background: rgba(40, 40, 40, 0.95);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.4);
            max-width: 900px;
            margin: auto;
            backdrop-filter: blur(10px);
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #444;
            gap: 15px;
            transition: transform 0.2s;
        }

        .cart-item:hover {
            transform: scale(1.02);
        }

        .cart-item img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        }

        .cart-item-title {
            font-size: 18px;
            font-weight: bold;
            color: #f1f1f1;
        }

        .cart-item-price {
            color: #4caf50;
            font-weight: bold;
            font-size: 16px;
        }

        .cart-footer {
            border-top: 2px solid #444;
            padding-top: 20px;
            margin-top: 20px;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-control button {
            width: 40px;
            height: 40px;
            font-size: 20px;
            border: none;
            background: linear-gradient(135deg, #ffa000, #ff5722);
            color: white;
            font-weight: bold;
            cursor: pointer;
            border-radius: 10px;
            transition: 0.3s;
        }

        .quantity-control button:hover {
            background: linear-gradient(135deg, #ff9800, #f44336);
        }

        .total-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 22px;
            font-weight: bold;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 15px;
        }

        .cart-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .remove-from-cart {
            background: none;
            border: none;
            color: red;
            font-size: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .remove-from-cart:hover {
            color: darkred;
        }

        .btn-modern {
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 8px;
            transition: 0.3s;
        }

        .btn-modern:hover {
            background: linear-gradient(135deg, #0072ff, #00c6ff);
        }

    </style>
</head>
<body>

    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">MyShop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="public_catalog.php">Catalogue</a></li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Panier <span id="cart-count" class="badge bg-warning">0</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bannière héroïque -->
    <section class="hero-banner">
        <div>🛍️ Votre Panier - Prêt à finaliser votre achat ?</div>
    </section>

    <!-- Contenu principal -->
    <main class="container my-5">
        <div class="cart-container">
            <div id="cart-container" class="row">
                <!-- Les articles du panier seront affichés ici dynamiquement -->
            </div>

            <!-- Résumé du panier -->
            <div class="cart-footer">
                <div class="total-container">
                    <span>Total :</span>
                    <span id="cart-total">0 €</span>
                </div>
                
                <div class="cart-actions">
                    <button id="clear-cart" class="btn btn-danger">🗑️ Vider le panier</button>
                    <a href="public_catalog.php" class="btn btn-secondary">🔄 Continuer les achats</a>
                    <button id="checkout-btn" class="btn-modern">✅ Passer la commande</button>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Importation du module JavaScript -->
    <script type="module">
        import { displayCartItems, updateCartCountUI } from '../../assets/components/cart.js';

        document.addEventListener("DOMContentLoaded", async () => {
            await displayCartItems(); 
            await updateCartCountUI();
        });
    </script>

</body>
</html>
