<?php

// Подключение к базе данных
include(__DIR__ . '/../src/db_connection.php');

// Старт сессии для проверки прав доступа
session_start();

/**
 * Проверка прав доступа для администратора.
 * Если пользователь не аутентифицирован или не является администратором, происходит перенаправление на страницу входа.
 */
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header("Location: login.php");
    exit();
}

/**
 * Обработка запроса на редактирование игры.
 * При получении запроса на редактирование, извлекаем информацию об игре из базы данных.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_game_id"])) {
    $game_id = $_POST["edit_game_id"];

    // Запрос для получения информации о выбранной игре из базы данных
    $sql = "SELECT * FROM plays WHERE id='$game_id'";
    $result = $conn->query($sql);

    // Проверка на наличие игры в базе данных
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $title = $row["title"];
        $genre = $row["genre"];
        $price = $row["price"];
        $image_path = $row["image_path"];
    } else {
        echo "Игра не найдена.";
        exit();
    }
}

/**
 * Обработка запроса на обновление данных игры.
 * При получении запроса на обновление данных игры, проверяется наличие нового изображения.
 * Если изображение загружено, происходит его сохранение на сервер и обновление информации в базе данных.
 * Если изображение не загружено, обновляются только текстовые данные игры.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_game"])) {
    $game_id = $_POST["game_id"];
    $title = $_POST["title"];
    $genre = $_POST["genre"];
    $price = $_POST["price"];

    // Проверка, было ли загружено новое изображение
    if ($_FILES['game_image']['size'] > 0) {
        $file_name = $_FILES['game_image']['name'];
        $file_size = $_FILES['game_image']['size'];
        $file_tmp = $_FILES['game_image']['tmp_name'];
        $file_type = $_FILES['game_image']['type'];

        // Указание пути для сохранения загруженного изображения
        $file_path = "uploads/" . $file_name;

        // Перемещение загруженного файла на сервер
        if (move_uploaded_file($file_tmp, $file_path)) {
            // Обновление информации о игре в базе данных с новым изображением
            $update_sql = "UPDATE plays SET title='$title', genre='$genre', price='$price', image_path='$file_path' WHERE id='$game_id'";
            if ($conn->query($update_sql) === TRUE) {
                echo "Информация об игре успешно обновлена!";
                header("Location: admin_panel.php");
                exit();
            } else {
                echo "Ошибка при обновлении информации об игре: " . $conn->error;
            }
        } else {
            echo "Ошибка при загрузке нового файла.";
        }
    } else {
        // Если изображение не было загружено, обновляем данные без изменений изображения
        $update_sql = "UPDATE plays SET title='$title', genre='$genre', price='$price' WHERE id='$game_id'";
        if ($conn->query($update_sql) === TRUE) {
            echo "Информация об игре успешно обновлена!";
            header("Location: admin_panel.php");
            exit();
        } else {
            echo "Ошибка при обновлении информации об игре: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать игру</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            background-image: url('1.jfif');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="file"],
        input[type="number"] {
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
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        h1,
        h2 {
            color: #333;
            text-align: center;
        }

        p {
            color: #555;
            text-align: center;
            margin-bottom: 15px;
        }

        .game-image {
            max-width: 100px;
            height: auto;
            display: block;
            margin: 0 auto;
            margin-bottom: 10px;
        }

        .edit-form {
            text-align: center;
        }

        .back-button {
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Редактировать игру</h1>

        <!-- Форма для редактирования игры -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" class="edit-form">
            <!-- Скрытое поле для хранения ID игры -->
            <input type="hidden" name="game_id" value="<?php echo $game_id; ?>">

            <label for="title">Название:</label>
            <input type="text" id="title" name="title" value="<?php echo $title; ?>" required>

            <label for="genre">Жанр:</label>
            <input type="text" id="genre" name="genre" value="<?php echo $genre; ?>" required>

            <label for="price">Цена:</label>
            <input type="number" id="price" name="price" min="0" step="0.01" value="<?php echo $price; ?>" required>

            <p><strong>Текущее изображение:</strong></p>
            <img src="/phpindividual/<?php echo htmlspecialchars($image_path); ?>" alt="Фото игры" class="game-image">

            <label for="game_image">Загрузить новое изображение :</label>
            <input type="file" id="game_image" name="game_image" accept="image/*">

            <input type="submit" name="update_game" value="Сохранить изменения">
        </form>

    </div>
</body>

</html>