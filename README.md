CODA_PROJET - E-Commerce MVC

📖 Introduction

Ce projet est un site e-commerce développé en PHP avec le pattern MVC. Il inclut un back-office pour la gestion des utilisateurs, catégories et produits, ainsi qu'un front-office interactif utilisant AJAX pour une navigation fluide.

🚀 Installation

1️⃣ Cloner le projet

git clone https://github.com/ton-utilisateur/CODA_PROJET.git
cd CODA_PROJET

2️⃣ Configurer la base de données

Crée une base de données MySQL nommée ecommerce_db.

Exécute le script database.sql pour générer les tables.

Configure la connexion dans includes/database.php :

$host = 'localhost';
$dbname = 'ecommerce_db';
$username = 'root';
$password = 'root';

3️⃣ Lancer le serveur local

Si tu utilises PHP en local, lance la commande :

php -S localhost:8888

Puis accède au site via :

http://localhost:8888/CODA_PROJET/mvc/view/front/public_catalog.php

🔑 Accès au Back-Office

Le back-office est accessible uniquement aux administrateurs.

Accède à la page de connexion :

http://localhost:8888/CODA_PROJET/mvc/view/login.php

Identifiants par défaut :

Name : admin

Mot de passe : admin123

🎨 Fonctionnalités

📌 Back-Office (Admin Panel)

Gestion des utilisateurs (CRUD)

Gestion des catégories (CRUD)

Gestion des produits (CRUD)

Système de connexion sécurisé

🛍️ Front-Office (Boutique en ligne)

Navigation AJAX fluide

Affichage du catalogue avec pagination

Recherche et filtres

Gestion du panier (AJAX)

Promotions dynamiques

⚙️ Technologies utilisées

PHP (MVC, MySQL)

JavaScript (Vanilla JS, AJAX, modules ES6)

Bootstrap pour le design

🔄 Déploiement sur GitHub

Crée un repository sur GitHub.

Initialise Git dans ton projet :

git init
git remote add origin https://github.com/ton-utilisateur/CODA_PROJET.git

Pousse le projet :

git checkout -b develop
git add .
git commit -m "Initial commit"
git push origin develop

Merge vers master pour la livraison :

git checkout master
git merge develop
git push origin master

📜 Licence

Ce projet est sous licence MIT. Libre à toi de le modifier et de l'adapter.


