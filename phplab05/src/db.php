<?php
/**
 * Функция для получения объекта PDO, который используется для работы с базой данных.
 *
 * @return PDO
 */
function getPDO(): PDO
{
    // Загружаем конфигурацию из файла
    $config = require __DIR__ . '/../config/db.php';

    // Формируем DSN для подключения к MySQL
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";

    try {
        // Пытаемся подключиться к базе данных с использованием PDO
        $pdo = new PDO($dsn, $config['user'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Включаем обработку ошибок
        ]);
        return $pdo;
    } catch (PDOException $e) {
        // Если ошибка подключения — выводим сообщение
        die("Ошибка подключения к БД: " . $e->getMessage());
    }
}
