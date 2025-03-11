<?php
// Задаем путь к папке с изображениями
$dir = 'image/';
// Сканируем содержимое директории
$files = scandir($dir);

// Если нет ошибок при сканировании
if ($files === false) {
    return;
}

// Создаем базовую структуру HTML страницы
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Галерея изображений</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
        nav {
            background-color: #444;
            overflow: hidden;
        }
        nav a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            display: inline-block;
        }
        nav a:hover {
            background-color: #ddd;
            color: black;
        }
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
            padding: 20px;
        }
        .gallery img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>

<header>
    <h1>Галерея изображений</h1>
</header>

<nav>
    <a href="#">Главная</a>
    <a href="#">О нас</a>
    <a href="#">Контакты</a>
</nav>

<div class="gallery">
<?php
// Проходим по списку файлов
foreach ($files as $file) {
    // Пропускаем текущий каталог и родительский
    if ($file != "." && $file != "..") {
        // Формируем полный путь к изображению
        $path = $dir . $file;
        // Проверяем, что это изображение с расширением .jpg
        if (pathinfo($file, PATHINFO_EXTENSION) == 'jpg') {
            echo "<div><img src='$path' alt='$file'></div>";
        }
    }
}
?>
</div>

<footer>
    <p> 2025 USM and Volkswagen AG</p>
</footer>

</body>
</html>
