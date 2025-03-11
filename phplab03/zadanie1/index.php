<?php
// Массив транзакций
$transactions = [
    [
        "id" => 1,
        "date" => "2019-01-01",
        "amount" => 100.00,
        "description" => "Payment for groceries",
        "merchant" => "SuperMart",
    ],
    [
        "id" => 2,
        "date" => "2020-02-15",
        "amount" => 75.50,
        "description" => "Dinner with friends",
        "merchant" => "Local Restaurant",
    ],
];

// Функция для подсчета общей суммы транзакций
function calculateTotalAmount(array $transactions): float {
    return array_sum(array_column($transactions, 'amount'));
}

// Вычисляем общую сумму
$totalAmount = calculateTotalAmount($transactions);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Задания с транзакциями.</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px;
        }
        th, td {
            padding: 8px;
            text-align: center;
            border: 1px solid #ccc;
        }
        th {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Дата</th>
            <th>Сумма</th>
            <th>Описание</th>
            <th>Магазин</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?= $transaction["id"] ?></td>
                <td><?= $transaction["date"] ?></td>
                <td><?= number_format($transaction["amount"], 2, '.', ' ') ?> руб.</td>
                <td><?= $transaction["description"] ?></td>
                <td><?= $transaction["merchant"] ?></td>
            </tr>
        <?php endforeach; ?>
        <!-- Строка для общей суммы -->
        <tr>
            <td colspan="4">Общая сумма:</td>
            <td><?= number_format($totalAmount, 2, '.', ' ') ?> руб.</td>
        </tr>
    </tbody>
</table>

</body>
</html>
