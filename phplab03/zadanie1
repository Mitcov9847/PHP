Лабораторная работа №3. Массивы и Функции

Цель работы

Освоить работу с массивами в PHP, применяя различные операции: создание, добавление, удаление, сортировка и поиск. Закрепить навыки работы с функциями, включая передачу аргументов, возвращаемые значения и анонимные функции.

Описание

Разработана система управления банковскими транзакциями, включающая:

Добавление новых транзакций

Удаление транзакций

Сортировку транзакций по дате или сумме

Поиск транзакций по описанию

Вычисление общей суммы всех транзакций

Определение количества дней с момента совершения транзакции

Структура проекта

├── index.php      # Основной файл с логикой работы
├── transactions.php # Файл с функциями для работы с транзакциями
├── style.css      # Файл со стилями
├── README.md      # Описание проекта

Установка и запуск

Убедитесь, что у вас установлен PHP 8+

Запустите локальный сервер командой:

php -S localhost:8000

Откройте в браузере: http://localhost:8000

Функционал

1. Подготовка среды

Включена строгая типизация:

<?php
declare(strict_types=1);

Файл index.php содержит основной код программы.

2. Создание массива транзакций

В transactions.php определён массив $transactions с данными:

$transactions = [
    ["id" => 1, "date" => "2019-01-01", "amount" => 100.00, "description" => "Payment for groceries", "merchant" => "SuperMart"],
    ["id" => 2, "date" => "2020-02-15", "amount" => 75.50, "description" => "Dinner with friends", "merchant" => "Local Restaurant"],
];

3. Вывод списка транзакций

Транзакции выводятся в HTML-таблице:

<table border='1'>
<thead>
    <tr>
        <th>ID</th><th>Дата</th><th>Сумма</th><th>Описание</th><th>Магазин</th><th>Дней прошло</th>
    </tr>
</thead>
<tbody>
<?php foreach ($transactions as $transaction): ?>
    <tr>
        <td><?= $transaction['id'] ?></td>
        <td><?= $transaction['date'] ?></td>
        <td><?= $transaction['amount'] ?></td>
        <td><?= $transaction['description'] ?></td>
        <td><?= $transaction['merchant'] ?></td>
        <td><?= daysSinceTransaction($transaction['date']) ?></td>
    </tr>
<?php endforeach; ?>
</tbody>
</table>

4. Реализация функций

Подсчёт общей суммы транзакций

function calculateTotalAmount(array $transactions): float {
    return array_sum(array_column($transactions, 'amount'));
}

Поиск транзакции по описанию

function findTransactionByDescription(string $descriptionPart, array $transactions) {
    return array_filter($transactions, fn($t) => strpos($t['description'], $descriptionPart) !== false);
}

Поиск транзакции по ID

function findTransactionById(int $id, array $transactions) {
    foreach ($transactions as $transaction) {
        if ($transaction['id'] === $id) return $transaction;
    }
    return null;
}

Подсчёт дней с момента транзакции

function daysSinceTransaction(string $date): int {
    return (new DateTime())->diff(new DateTime($date))->days;
}

Добавление новой транзакции

function addTransaction(array &$transactions, int $id, string $date, float $amount, string $description, string $merchant): void {
    $transactions[] = compact('id', 'date', 'amount', 'description', 'merchant');
}

5. Сортировка транзакций

По дате

usort($transactions, fn($a, $b) => strtotime($a['date']) <=> strtotime($b['date']));

По сумме (по убыванию)

usort($transactions, fn($a, $b) => $b['amount'] <=> $a['amount']);

Итог

В результате реализована система управления банковскими транзакциями с основными операциями (добавление, удаление, сортировка, поиск). Код структурирован и покрыт необходимыми функциями.
