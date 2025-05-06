<?php

/**
 * Обработка оформления заказа пользователем.
 * Получает данные из POST-запроса, рассчитывает общую сумму,
 * сохраняет заказ в базе данных и очищает корзину пользователя.
 *
 * @package EpicGamesStore
 */

include(__DIR__ . '/../src/db_connection.php');
session_start();

// Проверка, был ли отправлен POST-запрос
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Получение данных из формы
    $name = trim($_POST["name"]);
    $surname = trim($_POST["surname"]);
    $phoneNumber = trim($_POST["phone_number"]);
    $paymentMethod = $_POST["payment_method"];

    // Получение ID пользователя из сессии
    $userId = $_SESSION['user_id'] ?? null;

    if (!$userId) {
        die("Ошибка: пользователь не авторизован.");
    }

    // Получение игр из корзины текущего пользователя
    $cartItemsQuery = "
        SELECT plays.title AS game_title, plays.price AS game_price 
        FROM cart 
        INNER JOIN plays ON cart.game_id = plays.id 
        WHERE cart.user_id = ?
    ";
    $stmt = $conn->prepare($cartItemsQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Подсчет общей стоимости
    $totalPrice = 0;
    while ($row = $result->fetch_assoc()) {
        $totalPrice += (float)$row["game_price"];
    }
    $stmt->close();

    // Получение email пользователя
    $emailStmt = $conn->prepare("SELECT email FROM users WHERE id = ? LIMIT 1");
    $emailStmt->bind_param("i", $userId);
    $emailStmt->execute();
    $emailResult = $emailStmt->get_result();
    $userEmail = $emailResult->fetch_assoc()["email"];
    $emailStmt->close();

    // Сохранение заказа в таблицу orders
    $insertOrderStmt = $conn->prepare("
        INSERT INTO orders (user_id, name, surname, phone_number, email, payment_method, total_price)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $insertOrderStmt->bind_param("isssssd", $userId, $name, $surname, $phoneNumber, $userEmail, $paymentMethod, $totalPrice);

    if ($insertOrderStmt->execute()) {
        $insertOrderStmt->close();

        // Очистка корзины пользователя после успешного заказа
        $clearCartStmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $clearCartStmt->bind_param("i", $userId);
        if ($clearCartStmt->execute()) {
            $clearCartStmt->close();
            // Отображение страницы благодарности
            echo <<<HTML
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Спасибо за покупку</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background-color: #f8f9fa;
            background-image: url('1.jfif');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
        button {
            padding: 13px 22px;
            font-size: 18px;
            margin-top: 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Спасибо за покупку!</h1>
    <p>Ваш заказ успешно оформлен.</p>
    <a href="http://localhost/phpindividual/games_and_cart.php"><button>Вернуться на главную страницу</button></a>
</body>
</html>
HTML;
            exit();
        } else {
            echo "Ошибка при очистке корзины: " . $clearCartStmt->error;
        }
    } else {
        echo "Ошибка при оформлении заказа: " . $insertOrderStmt->error;
    }

    $conn->close();
}
