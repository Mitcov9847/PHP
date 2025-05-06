<?php

/**
 * Обработка формы входа пользователя.
 * Проверяет логин и пароль, устанавливает сессию и перенаправляет
 * пользователя в зависимости от его роли.
 *
 * @package EpicGamesStore
 */

include(__DIR__ . '/../src/db_connection.php');
session_start();


// Генерация CSRF токена
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Ошибка безопасности. Попробуйте снова.";
    } else {
        $username = filter_input(INPUT_POST, 'login_username', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = $_POST['login_password']; // пароль без фильтрации

        if ($username && $password) {
            $stmt = $conn->prepare("SELECT id, username, password, role_id FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows === 1) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user["password"])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role_id'];
                    $redirectUrl = ($user['role_id'] === 1) ? '/phpindividual/admin/admin_panel.php' : '/phpindividual/games_and_cart.php';
                    header("Location: $redirectUrl");
                    exit();
                }
            }
            $error = "Неверное имя пользователя или пароль.";
            $stmt->close();
        } else {
            $error = "Пожалуйста, заполните все поля.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Вход в систему</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9 url('1.jfif') no-repeat fixed center;
            background-size: cover;
            margin: 0;
        }

        .container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background: #0056b3;
        }

        .signup-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        .signup-link:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #b00020;
            background: #fdecea;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Вход в систему</h1>
        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <input type="text" name="login_username" placeholder="Имя пользователя" required>
            <input type="password" name="login_password" placeholder="Пароль" required>
            <input type="submit" value="Войти">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        </form>
        <a class="signup-link" href="/phpindividual/public/register.php">Зарегистрироваться</a>
    </div>
</body>

</html>