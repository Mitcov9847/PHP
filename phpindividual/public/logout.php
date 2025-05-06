<?php

session_start();

// Очищаем все переменные сессии
$_SESSION = array();

// Уничтожаем сессию
session_destroy();
// Перенаправляем пользователя на страницу входа
header("Location: login.php");
exit;
