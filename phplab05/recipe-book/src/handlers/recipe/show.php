<?php
require_once __DIR__ . '/../../db.php';

/**
 * Получаем PDO для работы с базой данных.
 */
$pdo = getPDO();

/**
 * Получаем ID рецепта из URL (GET параметра).
 */
$recipeId = $_GET['id'] ?? null;

if ($recipeId) {
    /**
     * Запрос для получения рецепта по ID, с добавлением имени категории.
     */
    $stmt = $pdo->prepare('SELECT r.*, c.name AS category_name FROM recipes r 
                           JOIN categories c ON r.category = c.id WHERE r.id = :id');
    $stmt->execute(['id' => $recipeId]);
    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

    // Если рецепт не найден
    if (!$recipe) {
        die('Рецепт не найден.');
    }
} else {
    die('ID рецепта не задан.');
}

/**
 * Подключаем шаблон для отображения рецепта.
 */
require_once __DIR__ . '/../../../templates/recipe/show.php';
