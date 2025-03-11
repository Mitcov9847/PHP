# Первое занятие: Банковские транзакции на PHP

## Описание функциональности
### 1. Создание массива транзакций
Файл `transactions.php` содержит массив транзакций:
```php
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
```
#### Пояснение: Массив $transactions содержит набор данных о транзакциях, каждая из которых представлена ассоциативным массивом с ключами: id, date, amount, description, и merchant. Эти ключи описывают идентификатор транзакции, дату, сумму, описание и магазин, в котором была совершена покупка.

### 2. Вывод транзакций в виде таблицы
Файл `index.php` загружает транзакции и выводит их в виде HTML-таблицы:
```php
<table border='1'>
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
        <td><?= $transaction["amount"] ?></td>
        <td><?= $transaction["description"] ?></td>
        <td><?= $transaction["merchant"] ?></td>
    </tr>
<?php endforeach; ?>
</tbody>
</table>
```

### 3. Функции работы с транзакциями
Файл `functions.php` содержит полезные функции:

#### Подсчет общей суммы транзакций
```php
function calculateTotalAmount(array $transactions): float {
    return array_sum(array_column($transactions, 'amount'));
}
```

#### Поиск транзакции по части описания
```php
function findTransactionByDescription(array $transactions, string $descriptionPart) {
    return array_filter($transactions, function($transaction) use ($descriptionPart) {
        return stripos($transaction['description'], $descriptionPart) !== false;
    });
}
```

#### Добавление новой транзакции
```php
function addTransaction(array &$transactions, int $id, string $date, float $amount, string $description, string $merchant): void {
    $transactions[] = [
        "id" => $id,
        "date" => $date,
        "amount" => $amount,
        "description" => $description,
        "merchant" => $merchant
    ];
}
```

#### Сортировка транзакций по дате
```php
usort($transactions, function ($a, $b) {
    return strtotime($a['date']) <=> strtotime($b['date']);
});
```

#### Сортировка транзакций по убыванию суммы
```php
usort($transactions, function ($a, $b) {
    return $b['amount'] <=> $a['amount'];
});
```
