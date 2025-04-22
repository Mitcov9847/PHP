<?php
/**
 * @file index.php
 * @description Главная страница с последними рецептами.
 */

$filepath = __DIR__ . '/../storage/recipes.txt';
$recipes = [];

if (file_exists($filepath)) {
    $lines = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $recipes = array_reverse(array_map('json_decode', $lines));
    $latest = array_slice($recipes, 0, 2);
} else {
    $latest = [];
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Каталог рецептов</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 2rem;
        }
        h1 {
            margin-bottom: 1rem;
        }
        .recipe {
            border-bottom: 1px solid #ccc;
            padding: 1rem 0;
        }
        .recipe h3 {
            margin: 0.2em 0;
        }
        .recipe p {
            margin: 0.3em 0;
        }
        .links {
            margin-top: 2rem;
        }
        .links a {
            display: inline-block;
            margin-right: 1rem;
            text-decoration: none;
            color: #0077cc;
        }
    </style>
</head>
<body>

<h1>Последние рецепты</h1>

<?php if (empty($latest)): ?>
    <p>Пока нет рецептов.</p>
<?php else: ?>
    <?php foreach ($latest as $recipe): ?>
        <div class="recipe">
            <h3><?= htmlspecialchars($recipe->title) ?></h3>
            <p><strong>Категория:</strong> <?= htmlspecialchars($recipe->category) ?></p>
            <p><strong>Описание:</strong><br><?= nl2br(htmlspecialchars($recipe->description)) ?></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<div class="links">
    <a href="/recipe/create.php">➕ Добавить новый рецепт</a>
    <a href="/recipe/index.php">📋 Все рецепты</a>
</div>

</body>
</html>
