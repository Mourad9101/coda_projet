<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des catégories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Liste des catégories</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom de la catégorie</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= htmlspecialchars($category['id']); ?></td>
                        <td><?= htmlspecialchars($category['name']); ?></td>
                        <td>
                            <!-- Bouton Modifier -->
                            <a href="index.php?component=category&action=edit&id=<?= $category['id']; ?>" class="btn btn-primary btn-sm">Modifier</a>

                            <!-- Bouton Supprimer -->
                            <a href="index.php?component=category&action=delete&id=<?= $category['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Bouton pour créer une nouvelle catégorie -->
        <a href="index.php?component=category&action=create" class="btn btn-success">Créer une catégorie</a>
    </div>
</body>
</html>
