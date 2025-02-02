<?php

function getUsers($pdo) {
    $query = "SELECT id, username, email, role FROM users";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function toggleEnabled(PDO $pdo, int $id): bool
{
    try {
        $stmt = $pdo->prepare("UPDATE users SET enabled = NOT enabled WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        throw new Exception("Erreur lors de la mise à jour de l'état de l'utilisateur : " . $e->getMessage());
    }
}

function deleteUsers(PDO $pdo, int $id): bool
{
    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        throw new Exception("Erreur lors de la suppression de l'utilisateur : " . $e->getMessage());
    }
}
?>