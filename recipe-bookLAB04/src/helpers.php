<?php
/**
 * @file helpers.php
 * @brief Утилиты для работы с рецептами: фильтрация и проверка данных формы.
 *
 * Включает:
 * - cleanInput() — удаляет лишние символы из строки
 * - checkRecipeForm() — проводит базовую валидацию формы рецепта
 *
 * Используется в: save_recipe.php
 */

/**
 * Приводит входную строку к безопасному виду
 *
 * @param string $input
 * @return string
 */
function cleanInput(string $input): string {
    return htmlspecialchars(trim(strip_tags($input)));
}

/**
 * Проверяет корректность данных рецепта
 *
 * @param array $form
 * @return array список найденных ошибок
 */
function checkRecipeForm(array $form): array {
    $issues = [];

    $requiredFields = [
        'title' => 'Укажите название рецепта',
        'category' => 'Категория обязательна',
        'ingredients' => 'Перечислите ингредиенты',
        'description' => 'Добавьте описание',
    ];

    foreach ($requiredFields as $field => $message) {
        if (empty($form[$field])) {
            $issues[$field] = $message;
        }
    }

    if (!isset($form['steps']) || !is_array($form['steps']) || count(array_filter($form['steps'])) === 0) {
        $issues['steps'] = 'Требуется хотя бы один шаг приготовления';
    }

    return $issues;
}
