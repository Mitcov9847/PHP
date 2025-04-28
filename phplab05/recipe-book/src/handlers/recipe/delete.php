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
     * Проверяем, существует ли рецепт с таким ID.
     */
    $stmt = $pdo->prepare('SELECT * FROM recipes WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($recipe) {
        /**
         * Удаляем рецепт с данным ID.
         */
        $stmt = $pdo->prepare('DELETE FROM recipes WHERE id = :id');
        $stmt->execute(['id' => $id]);

        /**
         * Перенаправляем, если удаление прошло успешно.
         */
        if ($stmt->rowCount() > 0) {
            header('Location: /recipe-book/public/?page=index');
            exit;
        } else {
            die('Ошибка удаления рецепта.');
        }
    } else {
        die('Рецепт не найден.');
    }
} else {
    die('ID рецепта не указан.');
}
