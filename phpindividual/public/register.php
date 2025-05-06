<?php

/**
 * Форма регистрации нового пользователя.
 * Обрабатывает POST-запрос, проверяет уникальность имени пользователя,
 * хеширует пароль и сохраняет нового пользователя в базу данных.
 *
 * @package EpicGames
 */

include(__DIR__ . '/../src/db_connection.php');
session_start();

$errorMessage = "";

// Обработка POST-запроса регистрации
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Получение и очистка данных из формы
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    /**
     * Проверка наличия пользователя с таким именем.
     *
     * @var mysqli_stmt $stmt
     */
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $errorMessage = "Пользователь с таким именем уже существует.";
    } else {
        // Хеширование пароля
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $defaultRoleId = 2;

        /**
         * Добавление нового пользователя в базу данных.
         */
        $insertStmt = $conn->prepare("INSERT INTO users (username, email, password, role_id) VALUES (?, ?, ?, ?)");
        $insertStmt->bind_param("sssi", $username, $email, $hashedPassword, $defaultRoleId);

        if ($insertStmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            $errorMessage = "Ошибка при регистрации: " . $conn->error;
        }

        $insertStmt->close();
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <style>
        /* Основные стили */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            background-image: url('1.jfif');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
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
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #ff0000;
            background-color: #ffebee;
            padding: 10px;
            border: 1px solid #e57373;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Регистрация</h1>

        <?php if (!empty($errorMessage)) : ?>
            <div class="error-message"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="username">Имя пользователя:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Зарегистрироваться">
        </form>

        <p>Уже зарегистрированы? <a href="login.php">Войти</a></p>
    </div>
</body>

</html>