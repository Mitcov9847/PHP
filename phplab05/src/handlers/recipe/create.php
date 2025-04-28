<?php
require_once __DIR__ . '/../../db.php';

/**
 * Получение экземпляра PDO для работы с базой данных.
 */
$pdo = getPDO();

/**
 * Проверка, был ли отправлен POST-запрос.
 * Если да — выполняем добавление рецепта в базу данных.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Извлекаем данные из формы. Если данные не переданы, то устанавливаем дефолтное значение.
    $title = $_POST['title'] ?? ''; 
    $category = (int) ($_POST['category'] ?? 0); // Преобразуем категорию в целое число
    $ingredients = $_POST['ingredients'] ?? ''; 
    $description = $_POST['description'] ?? ''; 
    $tags = $_POST['tags'] ?? ''; 
    $steps = $_POST['steps'] ?? ''; 

    /**
     * Простейшая валидация формы:
     * Проверяем обязательные поля: название и категория.
     * Если они не заполнены, выводим сообщение об ошибке.
     */
    if (empty($title) || $category === 0) {
        die('Название и категория обязательны.');
    }

    /**
     * Подготавливаем SQL-запрос для вставки данных о рецепте в базу данных.
     * Используем подготовленные выражения для защиты от SQL-инъекций.
     */
    $stmt = $pdo->prepare('INSERT INTO recipes (title, category, ingredients, description, tags, steps) 
                            VALUES (:title, :category, :ingredients, :description, :tags, :steps)');

    // Выполняем запрос с данными, переданными из формы.
    $stmt->execute([
        'title' => $title,
        'category' => $category,
        'ingredients' => $ingredients,
        'description' => $description,
        'tags' => $tags,
        'steps' => $steps,
    ]);

    /**
     * После успешного добавления рецепта, перенаправляем пользователя на главную страницу.
     */
    header('Location: /recipe-book/public/');
    exit;
}

/**
 * Если форма НЕ была отправлена, готовим данные для отображения на странице создания рецепта.
 * Загружаем все категории для выпадающего списка.
 */
$stmt = $pdo->query('SELECT * FROM categories ORDER BY name');
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

/**
 * Подключаем шаблон для отображения формы добавления рецепта.
 */
require_once __DIR__ . '/../../../templates/recipe/create.php';
