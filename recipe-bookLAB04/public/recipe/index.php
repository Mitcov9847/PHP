<?php
/**
 * @file index.php
 * @description Страница со списком рецептов и постраничной навигацией.
 */

$filepath = __DIR__ . '/../../storage/recipes.txt';
$recipes = [];

if (file_exists($filepath)) {
    $lines = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $recipes = array_reverse(array_map('json_decode', $lines));
}

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 5;
$total = count($recipes);
$totalPages = ceil($total / $perPage);
$offset = ($page - 1) * $perPage;
$currentRecipes = array_slice($recipes, $offset, $perPage);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список рецептов</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 2rem;
        }
        .recipe {
            border-bottom: 1px solid #ccc;
            padding: 1rem 0;
        }
        .recipe h3 {
            margin: 0.2em 0;
        }
        .recipe p, .recipe ol {
            margin: 0.3em 0;
        }
        .pagination a, .pagination strong {
            margin: 0 5px;
            text-decoration: none;
        }
        .pagination {
            margin-top: 2rem;
        }
    </style>
</head>
<body>

<h1>Рецепты (страница <?= $page ?>)</h1>

<?php if (empty($currentRecipes)): ?>
    <p>На этой странице рецептов нет.</p>
<?php else: ?>
    <?php foreach ($currentRecipes as $recipe): ?>
        <div class="recipe">
            <h3><?= htmlspecialchars($recipe->title) ?></h3>
            <p><strong>Категория:</strong> <?= htmlspecialchars($recipe->category) ?></p>
            <p><strong>Ингредиенты:</strong><br><?= nl2br(htmlspecialchars($recipe->ingredients)) ?></p>
            <p><strong>Описание:</strong><br><?= nl2br(htmlspecialchars($recipe->description)) ?></p>
            <p><strong>Шаги приготовления:</strong></p>
            <ol>
                <?php foreach ($recipe->steps as $step): ?>
                    <li><?= htmlspecialchars($step) ?></li>
                <?php endforeach; ?>
            </ol>
            <?php if (!empty($recipe->tags)): ?>
                <p><strong>Теги:</strong> <?= implode(', ', array_map('htmlspecialchars', $recipe->tags)) ?></p>
            <?php endif; ?>
            <p><em>Добавлено: <?= htmlspecialchars($recipe->created_at) ?></em></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<!-- Навигация по страницам -->
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>">&laquo; Назад</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <?php if ($i === $page): ?>
            <strong>[<?= $i ?>]</strong>
        <?php else: ?>
            <a href="?page=<?= $i ?>"><?= $i ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page + 1 ?>">Вперёд &raquo;</a>
    <?php endif; ?>
</div>

<p><a href="/index.php">На главную</a></p>

</body>
</html>
