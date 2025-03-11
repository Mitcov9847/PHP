
# Галерея изображений — PHP скрипт

## Описание

Этот скрипт предназначен для отображения изображений из папки `image/` на веб-странице в виде галереи. Он использует PHP для сканирования директории и вывода изображений с расширением `.jpg`.

## Структура кода

```php
<?php
/**
 * Задаем путь к папке с изображениями
 *
 * Этот скрипт сканирует директорию 'image/' и отображает изображения в формате .jpg в виде галереи.
 * Для корректной работы скрипта необходима папка с изображениями в текущей директории.
 *
 * @var string $dir Путь к папке с изображениями
 */
$dir = 'image/';

/**
 * Получает список файлов из указанной директории.
 *
 * Функция использует scandir для получения всех файлов в папке. Если сканирование не удается, выводится сообщение об ошибке.
 * Исключаются текущие и родительские директории ('.' и '..').
 *
 * @return array|false Массив с именами файлов или false в случае ошибки
 */
$files = scandir($dir);

/**
 * Проверка наличия ошибки при сканировании директории.
 *
 * Если файлы не были получены, выполнение скрипта завершается.
 */
if ($files === false) {
    echo "Ошибка при сканировании директории.";
    return;
}

/**
 * Основная структура HTML страницы
 */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Галерея изображений</title>
    <style>
        /* Стили для страницы, хедера, навигации, галереи и футера */
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
/**
 * Выводит изображения на экран.
 *
 * Скрипт проверяет каждый файл в директории на наличие расширения '.jpg' и отображает их как изображения.
 * Все изображения помещаются в сетку для отображения галереи.
 *
 * @param array $files Массив с именами файлов, полученный от scandir
 */
foreach ($files as $file) {
    // Пропускаем текущий каталог и родительский
    if ($file != "." && $file != "..") {
        // Формируем полный путь к изображению
        $path = $dir . $file;
        
        // Проверяем, что это изображение с расширением .jpg
        if (pathinfo($file, PATHINFO_EXTENSION) == 'jpg') {
            // Выводим изображение
            echo "<div><img src='$path' alt='$file'></div>";
        }
    }
}
?>
</div>

<footer>
    <p>&copy; 2025 Все права защищены</p>
</footer>

</body>
</html>
```

## Описание

1. **Переменные и функции**:
   - `@var string $dir`: Путь к папке с изображениями.
   - `@param array $files`: Массив с именами файлов, полученный от `scandir`.
   - `@return array|false`: Возвращает массив с именами файлов или `false` в случае ошибки.

2. **Функциональность**:
   - Скрипт сканирует папку `image/` на наличие файлов с расширением `.jpg` и отображает их на странице в виде галереи.

