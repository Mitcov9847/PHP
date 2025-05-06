<?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "games";
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Проверяем подключение
            if ($conn->connect_error) {
                die("Ошибка подключения к базе данных: " . $conn->connect_error);
            }