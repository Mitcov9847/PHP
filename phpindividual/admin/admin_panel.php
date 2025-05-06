<?php

session_start();
include(__DIR__ . '/../src/db_connection.php');

/**
 * Проверяет, является ли пользователь администратором.
 * Если пользователь не является администратором, он перенаправляется на страницу входа.
 */
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header("Location: login.php");
    exit();
}

$error_message = "";

/**
 * Обрабатывает запросы на добавление новой игры или удаление существующей игры.
 * При добавлении игры выполняется загрузка файла и сохранение данных в базу данных.
 * При удалении игры из базы данных выполняется соответствующий запрос на удаление.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Обработка запроса на добавление новой игры
    if (isset($_POST["title"], $_POST["genre"], $_POST["price"])) {
        // Фильтрация и валидация данных
        $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_SPECIAL_CHARS);
        $genre = filter_input(INPUT_POST, "genre", FILTER_SANITIZE_SPECIAL_CHARS);
        $price = filter_input(INPUT_POST, "price", FILTER_SANITIZE_SPECIAL_CHARS);

        if ($title && $genre && $price !== false) {
            // Остальной код загрузки файла и вставки в базу остаётся без изменений
            $file_name = basename($_FILES['game_image']['name']);
            $file_tmp = $_FILES['game_image']['tmp_name'];
            $file_store = "../uploads/" . $file_name;
            $db_file_path = "uploads/" . $file_name;

            if (move_uploaded_file($file_tmp, $file_store)) {
                $stmt = $conn->prepare("INSERT INTO plays (title, genre, price, image_path) VALUES (?, ?, ?, ?)");
                if ($stmt === false) {
                    $error_message = "Ошибка подготовки запроса: " . $conn->error;
                } else {
                    $stmt->bind_param("ssds", $title, $genre, $price, $db_file_path);
                    if ($stmt->execute()) {
                        header("Location: admin_panel.php");
                        exit();
                    } else {
                        $error_message = "Ошибка при добавлении игры: " . $stmt->error;
                    }
                    $stmt->close();
                }
            } else {
                $error_message = "Ошибка при загрузке файла.";
            }
        } else {
            $error_message = "Проверьте корректность заполнения всех полей.";
        }
    }

    // Обработка запроса на удаление игры...
}

// Обработка запроса на удаление игры
if (isset($_POST['delete_game'])) {
    $game_id = $_POST['delete_game'];
    $stmt = $conn->prepare("DELETE FROM plays WHERE id = ?");
    if ($stmt === false) {
        $error_message = "Ошибка подготовки запроса: " . $conn->error;
    } else {
        $stmt->bind_param("i", $game_id);
        if ($stmt->execute()) {
            header("Location: admin_panel.php");
            exit();
        } else {
            $error_message = "Ошибка при удалении игры: " . $stmt->error;
        }
        $stmt->close();
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <style>
        /* Основные стили для страницы */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(29, 27, 27);
            background-image: url('/phpindividual/images/backimg.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(240, 240, 240, 0.9));
            border-radius: 10px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1,
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            color: #555;
            text-align: center;
            margin-bottom: 15px;
        }

        input[type="text"],
        input[type="file"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
            transform: scale(1.02);
        }

        .game-item {
            background-color: #f0f0f0;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            width: 100%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.3s ease;
            position: relative;
            text-align: center;
        }

        .game-item:hover {
            background-color: #e0e0e0;
            transform: translateY(-2px);
        }

        .game-item img {
            max-width: 100px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .delete-button,
        .edit-button {
            position: absolute;
            top: 5px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 12px;
        }

        .delete-button {
            right: 5px;
            background-color: #ff0000;
        }

        .delete-button:hover {
            background-color: #cc0000;
        }

        .edit-button {
            right: 30px;
            background-color: #007bff;
        }

        .edit-button:hover {
            background-color: #0056b3;
        }

        .button-link {
            background-color: transparent;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px 20px;
            text-decoration: none;
            color: #333;
            transition: background-color 0.3s, color 0.3s;
        }

        .button-link:hover {
            background-color: #f0f0f0;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Панель администратора</h1>

        <!-- Вывод ошибки, если есть -->
        <?php if (!empty($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <!-- Форма для добавления новой игры -->
        <h2>Добавить новую игру:</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <label for="title">Название:</label>
            <input type="text" id="title" name="title" required>

            <label for="genre">Жанр:</label>
            <input type="text" id="genre" name="genre" required>

            <label for="price">Цена:</label>
            <input type="number" id="price" name="price" min="0" step="0.01" required>

            <label for="game_image">Фото:</label>
            <input type="file" id="game_image" name="game_image" accept="image/*" required>

            <input type="submit" value="Добавить игру">
        </form>

        <!-- Отображение существующих игр -->
        <h2>Существующие игры:</h2>
        <ul>
            <?php
            // Запрос на получение всех игр из базы данных
            $games_query = "SELECT id, title, genre, price, image_path FROM plays";
            $games_result = $conn->query($games_query);

            if ($games_result->num_rows > 0) {
                // Перебор всех игр и вывод их данных
                while ($row = $games_result->fetch_assoc()) {
                    echo "<li class='game-item'>";
                    echo "<p><strong>Название:</strong> " . htmlspecialchars($row["title"]) . "</p>";
                    echo "<p><strong>Жанр:</strong> " . htmlspecialchars($row["genre"]) . "</p>";
                    echo "<p><strong>Цена:</strong> $" . htmlspecialchars($row["price"]) . "</p>";
                    echo "<p><strong>Фото:</strong> <img src='/phpindividual/" . htmlspecialchars($row["image_path"]) . "' alt='Фото игры'></p>";

                    // Форма для редактирования игры
                    echo "<form action='edit_game.php' method='post' style='display:inline-block;'>";
                    echo "<input type='hidden' name='edit_game_id' value='" . $row["id"] . "'>";
                    echo "<button type='submit' class='edit-button'>E</button>";
                    echo "</form>";

                    // Форма для удаления игры
                    echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post' style='display:inline-block;'>";
                    echo "<input type='hidden' name='delete_game' value='" . $row["id"] . "'>";
                    echo "<button type='submit' class='delete-button'>X</button>";
                    echo "</form>";

                    echo "</li>";
                }
            } else {
                echo "<li>Нет доступных игр.</li>";
            }
            ?>
        </ul>

        <!-- Кнопка выхода -->
        <a href="/phpindividual/public/logout.php" class="button-link">Выйти</a>
    </div>
</body>

</html>