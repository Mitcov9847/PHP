<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Функция для добавления товара в корзину
function add_to_cart($game_id, $quantity = 1)
{
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    if (isset($_SESSION['cart'][$game_id])) {
        $_SESSION['cart'][$game_id] += $quantity;
    } else {
        $_SESSION['cart'][$game_id] = $quantity;
    }
}

// Функция для удаления товара из корзины
function remove_from_cart($game_id)
{
    if (isset($_SESSION['cart'][$game_id])) {
        unset($_SESSION['cart'][$game_id]);
    }
}

// Функция для отображения содержимого корзины
function display_cart()
{
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo "<p>Ваша корзина.</p>";
    } else {
        echo "<ul>";
        foreach ($_SESSION['cart'] as $game_id => $quantity) {
            echo "<li>Игра ID $game_id (количество: $quantity) <a href='remove_from_cart.php?game_id=$game_id'>Удалить</a></li>";
        }
        echo "</ul>";
    }
}


// Функция для расчета общей суммы заказа
function calculate_cart_total()
{
    $total = 0;
    // Перебираем элементы в корзине
    foreach ($_SESSION['cart'] as $item) {
        // Предположим, что в элементе корзины хранится цена товара
        $total += $item['price'];
    }
    return $total;
}

// Функция для очистки корзины
function clear_cart()
{
    // Устанавливаем сессию корзины в пустой массив
    $_SESSION['cart'] = array();
}
