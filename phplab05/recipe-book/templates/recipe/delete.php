<?php
$title = 'Удалить рецепт'; // Заголовок страницы

ob_start(); // Начинаем буферизацию вывода
?>

<h2>Удалить рецепт</h2>

<p>Вы действительно хотите удалить рецепт "<strong><?= htmlspecialchars($recipe['title']) ?></strong>"?</p>
<!-- Сообщение, подтверждающее удаление рецепта -->

<form action="/?page=delete&id=<?= htmlspecialchars($recipe['id']) ?>" method="post">
    <!-- Форма для подтверждения удаления рецепта -->

    <button type="submit" style="color: red;">Да, удалить</button>
    <!-- Кнопка для подтверждения удаления с красным текстом -->
    
    <a href="/?page=show&id=<?= htmlspecialchars($recipe['id']) ?>">Отмена</a>
    <!-- Ссылка для отмены удаления, возвращает на страницу рецепта -->
</form>

<?php
$content = ob_get_clean(); // Завершаем буферизацию вывода и сохраняем содержимое
require __DIR__ . '/../layout.php'; // Подключаем общий шаблон для страницы
