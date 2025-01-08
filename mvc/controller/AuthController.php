<?php
require_once './includes/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function processLogin() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['username'];
        $password = $_POST['password'];

        $pdo = getDatabaseConnection();

        $stmt = $pdo->prepare("SELECT * FROM users WHERE name = ?");
        $stmt->execute([$name]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            if ($user['role'] === 'admin') {

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];

                header('Location: index.php?action=dashboard');
                exit();
            } else {
                echo "Accès refusé. Vous n'êtes pas administrateur.";
            }
        } else {
            echo "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        echo "Requête non valide.";
    }
}
