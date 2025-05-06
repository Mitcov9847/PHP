<?php
session_start();
include(__DIR__ . '/../src/db_connection.php');

/**
 * Подсчитывает общую стоимость товаров в корзине и сохраняет её в сессии.
 *
 * Эта функция проходит по всем товарам в корзине, суммирует их стоимость и
 * сохраняет общую стоимость в сессии пользователя.
 *
 * @return void
 */
function calculateTotalPrice(): void
{
    $total_price = 0;

    // Проверяем, если корзина не пуста
    if (!empty($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        // Проходим по всем товарам в корзине
        foreach ($_SESSION['cart'] as $key => $value) {
            $total_price += $value['price']; // Добавляем цену каждого товара
        }
    }

    // Сохраняем общую цену в сессии
    $_SESSION['total_price'] = $total_price;
}

// Вызываем функцию подсчёта общей стоимости
calculateTotalPrice();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформление заказа</title>

    <style>
        /* Основные стили */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            background-image: url('1.jfif');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: calc(100% - 20px);
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Стили для ссылок */
        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Оформление заказа</h1>

        <!-- Форма оформления заказа -->
        <form action="process_order.php" method="post">
            <!-- Поля для ввода данных доставки и выбора способа оплаты -->
            Имя: <input type="text" name="name" required><br>
            Фамилия: <input type="text" name="surname" required><br>
            Номер телефона: <input type="text" name="phone_number" required><br>

            <!-- Скрытое поле для передачи общей суммы заказа -->
            <input type="hidden" name="total_price" value="<?php echo $_SESSION['total_price']; ?>">

            Способ оплаты:
            <select name="payment_method" required>
                <option value="">Выберите способ оплаты</option>
                <option value="credit_card">Кредитная карта</option>
                <option value="paypal">PayPal</option>
                <option value="QIWI">QIWI</option>
            </select><br>

            <input type="submit" value="Оформить заказ">
        </form>
    </div>

</body>

</html>