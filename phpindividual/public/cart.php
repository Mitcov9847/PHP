<?php

session_start();
include(__DIR__ . '/../src/db_connection.php');

/**
 * Проверка, если пользователь аутентифицирован. Если нет, перенаправляем на страницу входа.
 */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/**
 * Запрос для получения данных о товарах в корзине пользователя.
 * Данные включают название игры и цену.
 */
$cart_items_query = "SELECT plays.title AS game_name, plays.price AS game_price 
                     FROM cart 
                     INNER JOIN plays ON cart.game_id = plays.id 
                     WHERE cart.user_id = ?";
$stmt = $conn->prepare($cart_items_query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$total_price = 0;
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина</title>
    <style>
        /* Общие стили для страницы */
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
            background-image: url('1.jfif');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        /* Стили для шапки с логотипом и меню */
        .site-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 25px;
            background-color: #000000;
            border-bottom: 1px solid #ccc;
        }

        .site-header .logo img {
            height: 50px;
        }

        .nav-menu {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .nav-menu li {
            margin-left: 20px;
        }

        .nav-menu li a {
            text-decoration: none;
            color: rgb(97, 34, 157);
            font-weight: bold;
        }

        .nav-menu li a:hover {
            color: rgb(255, 255, 255);
        }

        /* Стили для обертки корзины */
        .cart-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Стили для таблицы */
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .cart-table th {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: left;
        }

        .cart-table td {
            border: 1px solid #ccc;
            padding: 10px;
        }

        .cart-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .cart-table tr:nth-child(odd) {
            background-color: #fff;
        }

        /* Стили ссылок */
        .checkout-link,
        .games_and_cart-link,
        .clear-cart-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .checkout-link {
            background-color: Green;
            color: #fff;
        }

        .checkout-link:hover {
            background-color: #006400;
        }

        .games_and_cart-link {
            background-color: #007bff;
            color: #fff;
        }

        .games_and_cart-link:hover {
            background-color: #0056b3;
        }

        .clear-cart-link {
            background-color: red;
            color: #fff;
        }

        .clear-cart-link:hover {
            background-color: #8B0000;
        }
    </style>
</head>

<body>
    <!-- Шапка сайта с логотипом и навигационным меню -->
    <header class="site-header">
        <div class="logo">
            <img src="../images/logo1.png" alt="Логотип">
        </div>
        <nav>
            <ul class="nav-menu">
                <li><a href="/phpindividual/games_and_cart.php">Главная</a></li>
                <li><a href="cart.php">Корзина</a></li>
                <li><a href="checkout.php">Оформление заказа</a></li>
                <li><a href="logout.php">Выход</a></li>
            </ul>
        </nav>
    </header>

    <div class="cart-container">
        <h2>Корзина</h2>
        <?php
        // Проверка наличия товаров в корзине
        if ($result->num_rows > 0) {
            echo "<table class='cart-table'>";
            echo "<thead><tr><th>Товар</th><th>Цена</th></tr></thead>";
            echo "<tbody>";

            // Выводим товары из корзины
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["game_name"] . "</td>";
                echo "<td>" . $row["game_price"] . " $.</td>";
                echo "</tr>";
                $total_price += $row["game_price"]; // Суммируем цену всех товаров
            }
            echo "</tbody>";
            echo "</table>";
            echo "<p>Общая сумма: " . $total_price . " $.</p>";
        } else {
            echo "<p>Корзина пуста.</p>";
        }
        $stmt->close();
        $conn->close();
        ?>
        <a class="clear-cart-link" href="clear_cart.php">Очистить корзину</a>
        <a class="checkout-link" href="checkout.php">Оформление заказа</a>
        <a class="games_and_cart-link" href="/phpindividual/games_and_cart.php">На главную страницу</a>
    </div>
</body>

</html>