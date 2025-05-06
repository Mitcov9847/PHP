<?php

/**
 * Подключение к базе данных.
 * Файл db_connection.php должен содержать логику подключения через PDO.
 *
 * @package EpicGames
 */

include(__DIR__ . '/../src/db_connection.php');

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epic Games - Главная</title>
    <style>
        /* --- Общие стили --- */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #ece9e6, #ffffff);
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 30px;
        }

        header h1 {
            margin: 0;
            font-size: 48px;
            font-weight: bold;
            color: #222;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }

        header p {
            font-size: 20px;
            color: #555;
        }

        nav {
            text-align: center;
            margin: 20px 0;
        }

        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #007bff;
            font-size: 18px;
            padding: 5px 10px;
            transition: background 0.3s, color 0.3s;
        }

        nav a:hover {
            background-color: rgba(0, 123, 255, 0.1);
            border-radius: 5px;
        }

        .banner {
            background: url(../images/banner.jpg) no-repeat center center;
            background-size: cover;
            height: 500px;
            border-radius: 10px;
            margin-bottom: 40px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            position: relative;
        }

        .banner::after {
            content: "";
            background: rgba(0, 0, 0, 0.25);
            border-radius: 10px;
        }

        .content {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        .content h2 {
            font-size: 32px;
            margin-bottom: 20px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        .content p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .games-list {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
        }

        .game-item {
            width: 240px;
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .game-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .game-item img {
            width: 100%;
            height: auto;
            display: block;
        }

        .game-item h3 {
            margin: 10px 0;
            font-size: 22px;
            color: #333;
        }

        .game-item p {
            font-size: 16px;
            color: #777;
            margin-bottom: 15px;
        }

        footer {
            text-align: center;
            font-size: 14px;
            color: #aaa;
            margin-top: 20px;
            padding: 20px 0;
            border-top: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>Epic Games</h1>
            <p>Ваш лучший выбор игр по привлекательным ценам!</p>
        </header>

        <nav>
            <a href="public.php">Главная</a>
            <a href="login.php">Вход</a>
            <a href="register.php">Регистрация</a>
            <a href="#games">Игры</a>
        </nav>

        <!-- Промо-баннер -->
        <div class="banner"></div>

        <!-- Блок "О нас" -->
        <div class="content">
            <h2>О нас</h2>
            <p>Добро пожаловать в Epic Games — лидера в продаже игр. У нас вы найдете актуальные новинки, классические хиты и эксклюзивные предложения от топовых издателей. Мы гордимся качеством сервиса и демократичными ценами.</p>
        </div>

        <!-- Список игр -->
        <div class="content" id="games">
            <h2>Наши игры</h2>
            <div class="games-list">
                <div class="game-item">
                    <img src="../images/logo1.png" alt="Gta5">
                    <h3>Игра 1</h3>
                    <p>Цена: $19.99</p>
                </div>
                <div class="game-item">
                    <img src="../images/logo1.png" alt="Gta5">
                    <h3>Игра 2</h3>
                    <p>Цена: $29.99</p>
                </div>
                <div class="game-item">
                    <img src="../images/logo1.png" alt="Gta5">
                    <h3>Игра 3</h3>
                    <p>Цена: $39.99</p>
                </div>
                <!-- Здесь можно динамически подгружать игры из базы -->
            </div>
        </div>

        <footer>
            <p>&copy; 2025 Epic Games. Все права защищены.</p>
        </footer>
    </div>
</body>

</html>