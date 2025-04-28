<?php
require_once __DIR__ . '/../src/db.php';
$pdo = getPDO();

// Получаем все рецепты из базы данных
$stmt = $pdo->query(
    'SELECT recipes.id, recipes.title, categories.name AS category_name 
     FROM recipes 
     JOIN categories ON recipes.category = categories.id 
     ORDER BY recipes.created_at DESC'
);
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$title = 'Все рецепты';

ob_start();
?>

<h2>Все рецепты</h2>

<p><a href="/recipe-book/public/?page=create">Добавить новый рецепт</a></p>

<ul>
    <?php foreach ($recipes as $recipe): ?>
        <li style="display: flex; justify-content: space-between; align-items: center; padding: 5px 0;">
            <!-- Заголовок рецепта и категория -->
            <span>
                <a href="/recipe-book/public/?page=show&id=<?= htmlspecialchars($recipe['id']) ?>">
                    <?= htmlspecialchars($recipe['title']) ?>
                </a>
                (Категория: <?= htmlspecialchars($recipe['category_name']) ?>)
            </span>

            <!-- Кнопки редактирования и удаления -->
            <span>
                <a href="/recipe-book/public/?page=edit&id=<?= htmlspecialchars($recipe['id']) ?>">Редактировать</a> |
                <a href="/recipe-book/public/?page=delete&id=<?= htmlspecialchars($recipe['id']) ?>"
                    onclick="return confirm('Вы уверены, что хотите удалить этот рецепт?');">Удалить</a>
            </span>
        </li>
    <?php endforeach; ?>
</ul>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';

