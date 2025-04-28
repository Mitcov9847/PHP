<?php
$title = 'Редактировать рецепт'; // Заголовок страницы

ob_start(); // Начинаем буферизацию вывода
?>

<h2>Редактировать рецепт</h2>

<form action="/recipe-book/public/?page=edit&id=<?= htmlspecialchars($recipe['id']) ?>" method="post">
    <!-- Форма для редактирования рецепта. Данные отправляются методом POST. ID рецепта передается в URL. -->

    <div>
        <label for="title">Название рецепта:</label><br>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($recipe['title']) ?>" required>
        <!-- Поле для ввода названия рецепта, значение предзаполнено текущим названием -->
    </div>

    <div>
        <label for="category">Категория:</label><br>
        <select id="category" name="category" required>
            <option value="">-- Выберите категорию --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= htmlspecialchars($cat['id']) ?>" <?= $recipe['category'] == $cat['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
                <!-- Выпадающий список для выбора категории рецепта. Текущая категория будет выбрана по умолчанию -->
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="ingredients">Ингредиенты:</label><br>
        <textarea id="ingredients" name="ingredients" rows="4"><?= htmlspecialchars($recipe['ingredients']) ?></textarea>
        <!-- Текстовое поле для ввода ингредиентов, предзаполнено текущими значениями -->
    </div>

    <div>
        <label for="description">Описание:</label><br>
        <textarea id="description" name="description" rows="4"><?= htmlspecialchars($recipe['description']) ?></textarea>
        <!-- Текстовое поле для ввода описания рецепта, предзаполнено текущими данными -->
    </div>

    <div>
        <label for="tags">Теги (через запятую):</label><br>
        <input type="text" id="tags" name="tags" value="<?= htmlspecialchars($recipe['tags']) ?>">
        <!-- Поле для ввода тегов рецепта -->
    </div>

    <div>
        <label for="steps">Шаги приготовления:</label><br>
        <textarea id="steps" name="steps" rows="6"><?= htmlspecialchars($recipe['steps']) ?></textarea>
        <!-- Текстовое поле для ввода шагов приготовления рецепта, предзаполнено текущими данными -->
    </div>

    <br>
    <button type="submit">Сохранить изменения</button>
    <!-- Кнопка для отправки формы с изменениями -->
</form>

<?php
$content = ob_get_clean(); // Завершаем буферизацию вывода и сохраняем содержимое
require __DIR__ . '/../layout.php'; // Подключаем общий шаблон для страницы

