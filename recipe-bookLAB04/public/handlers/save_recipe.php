<?php
/**
 * @file save_recipe.php
 * @brief Обработчик формы добавления рецепта.
 *
 * Получает данные из формы (POST), выполняет:
 * - фильтрацию и очистку данных;
 * - валидацию обязательных полей;
 * - сохранение валидных данных в файл storage/recipes.txt в формате JSON;
 * - сохранение ошибок и возврат на форму при неудаче;
 * - перенаправление на главную при успехе.
 *
 * Использует:
 * - cleanInput() и checkRecipeForm() из helpers.php
 * - session для передачи ошибок и старых значений
 */

ob_start(); 
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

require_once __DIR__ . '/../../src/helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Очистка данных
    $title = cleanInput($_POST['title'] ?? '');
    $category = cleanInput($_POST['category'] ?? '');
    $ingredients = cleanInput($_POST['ingredients'] ?? '');
    $description = cleanInput($_POST['description'] ?? '');
    $tags = $_POST['tags'] ?? [];

    // Обработка шагов
    $stepsRaw = $_POST['steps'] ?? [];
    $steps = array_filter(array_map('cleanInput', $stepsRaw));

    // Сбор всех данных
    $formData = [
        'title' => $title,
        'category' => $category,
        'ingredients' => $ingredients,
        'description' => $description,
        'tags' => $tags,
        'steps' => $steps,
        'created_at' => date('Y-m-d H:i:s')
    ];

    // Валидация
    $errors = checkRecipeForm($formData);

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $_POST;
        header('Location: ../../public/recipe/create.php');
        exit;
    }

    // Сохранение в файл
    $line = json_encode($formData, JSON_UNESCAPED_UNICODE) . PHP_EOL;
    file_put_contents(__DIR__ . '/../../storage/recipes.txt', $line, FILE_APPEND);

    header('Location: ../../public/index.php');
    exit;
}
