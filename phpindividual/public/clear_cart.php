<?php

/**
 * Очищает корзину пользователя, удаляя все товары для текущего пользователя.
 * Перенаправляет пользователя на страницу игр и корзины после успешной очистки.
 * 
 * @return void
 */
function clearCart(): void
{
    include(__DIR__ . '/../src/db_connection.php');
    session_start();

    // Проверяем, если пользователь аутентифицирован
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Выполняем запрос для удаления всех товаров из корзины
        $sql = "DELETE FROM cart WHERE user_id = $user_id";

        // Проверка, успешно ли выполнен запрос
        if ($conn->query($sql) === TRUE) {
            // Если корзина успешно очищена, перенаправляем на страницу games_and_cart.php
            header("Location: /phpindividual/games_and_cart.php");
            exit(); // Завершаем выполнение скрипта после перенаправления
        }
        // Закрытие соединения с базой данных
        $conn->close();
    } else {
        echo "Вы не аутентифицированы.";
    }
}

// Вызов функции для очистки корзины
clearCart();

?>

// Вызов функции для очистки корзины и прекращение дальнейшего выполнения
clearCart();

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Очистить корзину</title>
    <style>
        .clear-cart-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #ff0000;
            /* Цвет фона */
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .clear-cart-link:hover {
            background-color: #cc0000;
            /* Цвет фона при наведении */
        }
    </style>
</head>

<body>
    <div style="text-align: center; margin-top: 50px;">
        <a href="clear_cart.php" class="clear-cart-link">Очистить корзину</a>
    </div>
</body>

</html>