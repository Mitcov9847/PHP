# Банковские транзакции на PHP

## Описание проекта
Этот проект представляет собой систему управления банковскими транзакциями с возможностью:
- Добавления новых транзакций
- Удаления транзакций
- Сортировки транзакций по дате или сумме
- Поиска транзакций по описанию

Проект разработан с использованием PHP и демонстрирует работу с массивами и функциями.

## Требования
- PHP 8+

## Установка и запуск
1. Убедитесь, что у вас установлен PHP 8 или выше. 
2. Склонируйте репозиторий:
   ```sh
   git clone https://github.com/yourusername/bank-transactions.git
   ```
3. Перейдите в папку проекта:
   ```sh
   cd bank-transactions
   ```
4. Запустите встроенный сервер PHP:
   ```sh
   php -S localhost:8000
   ```
5. Откройте браузер и перейдите по адресу `http://localhost:8000`.

## Структура проекта
```
├── index.php        # Основной файл проекта
├── functions.php    # Файл с функциями работы с транзакциями
├── transactions.php # Файл с массивом транзакций
├── styles.css       # Стили для таблицы (если нужно)
└── README.md        # Документация
```

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

## Лицензия
Этот проект распространяется под лицензией MIT.
