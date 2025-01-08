<?php
session_start();

$action = $_GET['action'] ?? 'login';

if ($action === 'login') {
    require './view/auth/login.php'; // Afficher le formulaire de connexion
} elseif ($action === 'process_login') {
    require './controller/AuthController.php'; // Gérer la validation du formulaire
    processLogin(); // Appeler la fonction de validation
} elseif ($action === 'dashboard') {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header('Location: index.php?action=login'); // Rediriger vers la page de connexion si non connecté
        exit();
    }
    require './view/auth/dashboard.php'; // Afficher le tableau de bord
} elseif ($action === 'logout') {
    session_destroy(); // Détruire la session
    header('Location: index.php?action=login'); // Rediriger vers la page de connexion
} else {
    echo "Page non trouvée.";
}
?>
