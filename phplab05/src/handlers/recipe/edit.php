<?php
require_once __DIR__ . '/../../db.php';

/**
 * Получаем PDO для работы с базой данных.
 */
$pdo = getPDO();

/**
 * Проверяем наличие ID в GET-параметре.
 */
if (isset($_GET['id'])) {
    $id = (int) $_GET['id']; // Преобразуем ID в число

    /**
     * Получаем данные рецепта по ID.
     */
    $stmt = $pdo->prepare('SELECT * FROM recipes WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

    // Если рецепт найден
    if ($recipe) {
        /**
         * Если форма отправлена методом POST, обновляем рецепт.
         */
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $category = (int) ($_POST['category'] ?? 0);
            $ingredients = $_POST['ingredients'] ?? '';
            $description = $_POST['description'] ?? '';
            $tags = $_POST['tags'] ?? '';
            $steps = $_POST['steps'] ?? '';

            // Валидация обязательных полей
            if (empty($title) || $category === 0) {
                die('Название и категория обязательны.');
            }

            /**
             * Обновляем рецепт в базе данных.
             */
            $stmt = $pdo->prepare('UPDATE recipes SET title = :title, category = :category, ingredients = :ingredients, description = :description, tags = :tags, steps = :steps WHERE id = :id');
            $stmt->execute([
                'title' => $title,
                'category' => $category,
                'ingredients' => $ingredients,
                'description' => $description,
                'tags' => $tags,
                'steps' => $steps,
                'id' => $id
            ]);

            /**
             * Перенаправляем на страницу с обновленным рецептом.
             */
            header('Location: /recipe-book/public/?page=show&id=' . $id);
            exit;
        }

        /**
         * Получаем список категорий для формы.
         */
        $stmt = $pdo->query('SELECT * FROM categories ORDER BY name');
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /**
         * Подключаем шаблон редактирования рецепта.
         */
        require_once __DIR__ . '/../../../templates/recipe/edit.php';
    } else {
        die('Рецепт не найден.');
    }
} else {
    die('ID рецепта не указан.');
}
