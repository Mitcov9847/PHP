<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <!-- Заголовок страницы, если переменная $title не установлена, используется "Recipe Book" -->
    <title><?= $title ?? 'Recipe Book' ?></title>
</head>
<body>
    <header>
        <h1>Проект Recipe Book</h1>
        <nav>
            <!-- Ссылка на главную страницу -->
            <a href="/recipe-book/public/?page=index">Главная</a>
        </nav>
        <hr>
    </header>

    <main>
        <!-- Контент страницы. Если переменная $content не установлена, то выводится пустая строка -->
        <?= $content ?? '' ?>
    </main>

    <footer>
        <hr>
        <!-- Футер с текущим годом -->
        <p>&copy; <?= date('Y') ?> USM book</p>
    </footer>
</body>
</html>
