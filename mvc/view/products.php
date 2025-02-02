<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .promo-price {
            color: red;
            font-weight: bold;
        }
        .old-price {
            text-decoration: line-through;
            color: grey;
        }
        .promo-badge {
            background: red;
            color: white;
            padding: 3px 8px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 4px;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <h1 class="mb-4">Liste des produits</h1>

        <!-- Filtre par catégorie -->
        <form method="get" action="index.php" class="mb-3">
            <input type="hidden" name="component" value="products">
            <label for="category_id" class="form-label">Filtrer par catégorie :</label>
            <div class="d-flex">
                <select name="category_id" id="category_id" class="form-select me-2">
                    <option value="">Toutes les catégories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id']; ?>" <?= isset($selectedCategory) && $selectedCategory == $category['id'] ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Promotion</th>
                    <th>Fin Promo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= htmlspecialchars($product['id']); ?></td>
                            <td>
                                <?= htmlspecialchars($product['name']); ?>
                                <?php if (!empty($product['promo_price']) && $product['promo_end'] >= date('Y-m-d')): ?>
                                    <span class="promo-badge">Promo</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($product['category'] ?? 'Sans catégorie'); ?></td>
                            <td><?= htmlspecialchars($product['description']); ?></td>
                            <td>
                                <?php if (!empty($product['image'])): ?>
                                    <img src="<?= htmlspecialchars($product['image']); ?>" alt="Image du produit" style="width: 50px;">
                                <?php else: ?>
                                    <span class="text-muted">Aucune image</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($product['promo_price']) && $product['promo_end'] >= date('Y-m-d')): ?>
                                    <span class="promo-price"><?= number_format($product['promo_price'], 2); ?> €</span><br>
                                    <span class="old-price"><?= number_format($product['price'], 2); ?> €</span>
                                <?php else: ?>
                                    <?= number_format($product['price'], 2); ?> €
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($product['stock']); ?></td>
                            <td>
                                <?= !empty($product['promo_price']) && $product['promo_end'] >= date('Y-m-d') ? number_format($product['promo_price'], 2) . ' €' : '<span class="text-muted">Pas de promo</span>'; ?>
                            </td>
                            <td>
                                <?= !empty($product['promo_end']) && $product['promo_end'] >= date('Y-m-d') ? htmlspecialchars($product['promo_end']) : '<span class="text-muted">-</span>'; ?>
                            </td>
                            <td>
                                <a href="index.php?component=product&action=edit&id=<?= $product['id']; ?>" class="btn btn-primary btn-sm">Modifier</a>
                                <a href="index.php?component=product&action=delete&id=<?= $product['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center text-muted">Aucun produit trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="mt-3">
            <a href="index.php?component=product&action=create" class="btn btn-success">Créer un produit</a>
        </div>
    </div>

</body>
</html>
