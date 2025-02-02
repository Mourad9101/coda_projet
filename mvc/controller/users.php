<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../model/users.php';

$pdo = getDatabaseConnection();
$users = getUsers($pdo);

require_once __DIR__ . '/../view/users.php';
?>