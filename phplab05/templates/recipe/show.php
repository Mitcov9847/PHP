<?php
$title = 'Рецепт: ' . htmlspecialchars($recipe['title']); // Заголовок страницы, включающий название рецепта

ob_start(); // Начинаем буферизацию вывода
?>

<h2>Рецепт: <?= htmlspecialchars($recipe['title']) ?></h2>
<!-- Заголовок с названием рецепта -->

<p><strong>Категория:</strong> <?= htmlspecialchars($recipe['category_name']) ?></p>
<!-- Отображаем категорию рецепта -->

<p><strong>Ингредиенты:</strong></p>
<p><?= nl2br(htmlspecialchars($recipe['ingredients'])) ?></p>
<!-- Отображаем ингредиенты рецепта. Функция nl2br преобразует новые строки в <br> для корректного отображения -->

<p><strong>Описание:</strong></p>
<p><?= nl2br(htmlspecialchars($recipe['description'])) ?></p>
<!-- Отображаем описание рецепта с переносами строк -->

<p><strong>Теги:</strong> <?= htmlspecialchars($recipe['tags']) ?></p>
<!-- Отображаем теги рецепта -->

<p><strong>Шаги приготовления:</strong></p>
<p><?= nl2br(htmlspecialchars($recipe['steps'])) ?></p>
<!-- Отображаем шаги приготовления рецепта с преобразованием новых строк в <br> -->

<a href="/recipe-book/public/?page=index">Назад к списку рецептов</a>
<!-- Ссылка на главную страницу с перечнем рецептов -->

<?php
$content = ob_get_clean(); // Завершаем буферизацию вывода и сохраняем содержимое
require __DIR__ . '/../layout.php'; // Подключаем общий шаблон для страницы

