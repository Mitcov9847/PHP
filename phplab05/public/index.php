<!-- Файл templates/index.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Рецепты</title>
</head>
<body>
    <h1>Список рецептов</h1>
    <ul>
        <?php foreach ($recipes as $recipe): ?>
            <li>
                <a href="index.php?page=recipe&id=<?= $recipe['id']; ?>">
                    <?= htmlspecialchars($recipe['title']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="index.php?page=create">Добавить рецепт</a>
</body>
</html>
