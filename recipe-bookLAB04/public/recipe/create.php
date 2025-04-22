<?php
/**
 * @file create.php
 * @description Интерфейс добавления нового рецепта в приложение.
 *
 * Использует сессию для передачи ошибок и сохранения данных пользователя при ошибке.
 */

session_start();

$formErrors = $_SESSION['errors'] ?? [];
$formData = $_SESSION['old'] ?? [];

unset($_SESSION['errors'], $_SESSION['old']);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Новый рецепт</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 2rem;
        }
        input, textarea, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 6px;
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 16px;
        }
        .error-message {
            color: crimson;
            font-size: 13px;
            margin-top: -5px;
        }
    </style>
</head>
<body>

<h2>Добавление рецепта</h2>

<form action="/handlers/save_recipe.php" method="post">
    <div class="form-group">
        <label for="title">Название рецепта:</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($formData['title'] ?? '') ?>" placeholder="Например, Блины с творогом">
        <?php if (!empty($formErrors['title'])): ?>
            <div class="error-message"><?= $formErrors['title'] ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="category">Категория:</label>
        <select id="category" name="category">
            <option value="">-- Выберите категорию --</option>
            <?php foreach (['Супы', 'Салаты', 'Десерты'] as $option): ?>
                <option value="<?= $option ?>" <?= ($formData['category'] ?? '') === $option ? 'selected' : '' ?>>
                    <?= $option ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($formErrors['category'])): ?>
            <div class="error-message"><?= $formErrors['category'] ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="ingredients">Ингредиенты:</label>
        <textarea id="ingredients" name="ingredients" rows="4" placeholder="Список ингредиентов через запятую"><?= htmlspecialchars($formData['ingredients'] ?? '') ?></textarea>
        <?php if (!empty($formErrors['ingredients'])): ?>
            <div class="error-message"><?= $formErrors['ingredients'] ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="description">Описание:</label>
        <textarea id="description" name="description" rows="3" placeholder="Краткое описание рецепта"><?= htmlspecialchars($formData['description'] ?? '') ?></textarea>
        <?php if (!empty($formErrors['description'])): ?>
            <div class="error-message"><?= $formErrors['description'] ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="tags">Теги:</label>
        <select name="tags[]" id="tags" multiple size="4">
            <?php foreach (['Веган', 'Безглютеновый', 'Праздничный', 'Быстрый'] as $tag): ?>
                <option value="<?= $tag ?>" <?= in_array($tag, $formData['tags'] ?? []) ? 'selected' : '' ?>><?= $tag ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Шаги приготовления:</label>
        <div id="steps-wrapper">
            <?php foreach ($formData['steps'] ?? [''] as $instruction): ?>
                <input type="text" name="steps[]" value="<?= htmlspecialchars($instruction) ?>" placeholder="Опишите шаг..." required>
            <?php endforeach; ?>
        </div>
        <?php if (!empty($formErrors['steps'])): ?>
            <div class="error-message"><?= $formErrors['steps'] ?></div>
        <?php endif; ?>
        <button type="button" id="add-step-btn">+ Добавить шаг</button>
    </div>

    <button type="submit">Сохранить рецепт</button>
</form>

<script>
    // Позволяет добавлять дополнительные шаги в форму
    document.getElementById('add-step-btn').addEventListener('click', () => {
        const stepField = document.createElement('input');
        stepField.type = 'text';
        stepField.name = 'steps[]';
        stepField.placeholder = 'Опишите шаг...';
        stepField.required = true;
        document.getElementById('steps-wrapper').appendChild(stepField);
    });
</script>

</body>
</html>
