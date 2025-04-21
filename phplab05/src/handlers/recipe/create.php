<?php
require_once __DIR__ . '/../../../src/db.php';
require_once __DIR__ . '/../../../src/helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = getPDO();

    $title = $_POST['title'] ?? '';
    $category = $_POST['category'] ?? 0;
    $ingredients = $_POST['ingredients'] ?? '';
    $description = $_POST['description'] ?? '';
    $tags = $_POST['tags'] ?? '';
    $steps = $_POST['steps'] ?? '';

    // Простая валидация
    if (empty($title) || empty($category)) {
        die('Ошибка: заполните обязательные поля');
    }

    $stmt = $pdo->prepare("
        INSERT INTO recipes (title, category, ingredients, description, tags, steps)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([$title, $category, $ingredients, $description, $tags, $steps]);

    header('Location: /');
    exit;
}
