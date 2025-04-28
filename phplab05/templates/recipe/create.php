<?php
$title = 'Добавить рецепт'; // Устанавливаем заголовок страницы

ob_start(); // Начинаем буферизацию вывода

?>

<h2>Добавить рецепт</h2>

<form action="/recipe-book/public/?page=create" method="post">
    <!-- Форма для добавления рецепта -->
    
    <div>
        <label for="title">Название рецепта:</label><br>
        <!-- Поле для ввода названия рецепта -->
        <input type="text" id="title" name="title" required>
    </div>

    <div>
        <label for="category">Категория:</label><br>
        <!-- Выпадающий список для выбора категории -->
        <select id="category" name="category" required>
            <option value="">-- Выберите категорию --</option>
            <?php foreach ($categories as $cat): ?>
                <!-- Перебираем категории и выводим их в список -->
                <option value="<?= htmlspecialchars($cat['id']) ?>">
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="ingredients">Ингредиенты:</label><br>
        <!-- Текстовое поле для ввода ингредиентов -->
        <textarea id="ingredients" name="ingredients" rows="4"></textarea>
    </div>

    <div>
        <label for="description">Описание:</label><br>
        <!-- Текстовое поле для описания рецепта -->
        <textarea id="description" name="description" rows="4"></textarea>
    </div>

    <div>
        <label for="tags">Теги (через запятую):</label><br>
        <!-- Поле для ввода тегов -->
        <input type="text" id="tags" name="tags">
    </div>

    <div>
        <label for="steps">Шаги приготовления:</label><br>
        <!-- Текстовое поле для описания шагов приготовления -->
        <textarea id="steps" name="steps" rows="6"></textarea>
    </div>

    <br>
    <button type="submit">Сохранить</button> <!-- Кнопка для отправки формы -->
</form>

<?php
$content = ob_get_clean(); // Завершаем буферизацию вывода и сохраняем содержимое
require __DIR__ . '/../layout.php'; // Подключаем общий шаблон для страницы
