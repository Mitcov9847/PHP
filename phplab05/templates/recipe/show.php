<!-- Файл templates/recipe/show.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($recipe['title']); ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($recipe['title']); ?></h1>
    <p><strong>Категория:</strong> <?= htmlspecialchars($recipe['category']); ?></p>
    <p><strong>Ингредиенты:</strong> <?= nl2br(htmlspecialchars($recipe['ingredients'])); ?></p>
    <p><strong>Описание:</strong> <?= nl2br(htmlspecialchars($recipe['description'])); ?></p>
    <p><strong>Теги:</strong> <?= htmlspecialchars($recipe['tags']); ?></p>
    <p><strong>Шаги:</strong> <?= nl2br(htmlspecialchars($recipe['steps'])); ?></p>
</body>
</html>
