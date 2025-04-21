<?php
$pdo = getPDO();

$stmt = $pdo->query("
    SELECT recipes.*, categories.name AS category_name
    FROM recipes
    JOIN categories ON recipes.category = categories.id
    ORDER BY recipes.created_at DESC
");

$recipes = $stmt->fetchAll();
?>

<h2>Все рецепты</h2>

<?php if (empty($recipes)): ?>
    <p>Рецептов пока нет. <a href="/index.php?page=create">Добавить</a></p>
<?php else: ?>
    <ul>
        <?php foreach ($recipes as $recipe): ?>
            <li>
                <h3><a href="/index.php?page=recipe&id=<?= $recipe['id'] ?>"><?= htmlspecialchars($recipe['title']) ?></a></h3>
                <p><strong>Категория:</strong> <?= htmlspecialchars($recipe['category_name']) ?></p>
                <p><strong>Описание:</strong> <?= nl2br(htmlspecialchars($recipe['description'])) ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
