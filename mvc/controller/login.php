<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../model/login.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $pdo = getDatabaseConnection();
    $user = VerifAdmin($pdo, $username);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['auth'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        echo json_encode(['authentication' => true]);
    } else {
        echo json_encode(['errors' => ['Nom d\'utilisateur ou mot de passe incorrect']]);
    }
    exit;
}
