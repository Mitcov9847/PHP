<?php
$pdo = getPDO();
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
?>

<h2>Добавить рецепт</h2>

<form action="/index.php?page=handle_create" method="post">
    <label>Название:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Категория:</label><br>
    <select name="category" required>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Ингредиенты:</label><br>
    <textarea name="ingredients" rows="4" cols="50"></textarea><br><br>

    <label>Описание:</label><br>
    <textarea name="description" rows="4" cols="50"></textarea><br><br>

    <label>Теги (через запятую):</label><br>
    <input type="text" name="tags"><br><br>

    <label>Шаги приготовления:</label><br>
    <textarea name="steps" rows="6" cols="50"></textarea><br><br>

    <button type="submit">Сохранить</button>
</form>
