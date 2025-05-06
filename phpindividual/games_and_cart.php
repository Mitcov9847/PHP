<?php
ob_start();
session_start();

require_once(__DIR__ . '/src/db_connection.php');

// Получаем поисковый запрос, если он передан
$search_keyword = "";
if (isset($_GET['search'])) {
    $search_keyword = trim($_GET['search']);
}

/**
 * Добавляет игру в корзину пользователя.
 *
 * @param int $user_id Идентификатор пользователя из сессии.
 * @param int $game_id Идентификатор игры, отправленный через POST.
 * @return void
 */
function addGameToCart(int $user_id, int $game_id): void
{
    global $conn;

    $stmt = $conn->prepare("INSERT INTO cart (user_id, game_id) VALUES (?, ?)");
    if ($stmt) {
        $stmt->bind_param("ii", $user_id, $game_id);
        if ($stmt->execute()) {
            header("Location: public/cart.php");
            exit();
        } else {
            echo "Ошибка при добавлении игры в корзину: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Ошибка подготовки запроса: " . $conn->error;
    }
}

// Обработка отправки формы добавления в корзину
if (isset($_POST["game_id"], $_SESSION['user_id'])) {
    $user_id = (int)$_SESSION['user_id'];
    $game_id = (int)$_POST["game_id"];
    addGameToCart($user_id, $game_id);
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Игры и корзина</title>
    <style>
        /* Стилизация страницы и элементов */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            background-image: url('images/backimg.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1,
        h2,
        p {
            text-align: center;
        }

        h1,
        h2 {
            color: #333;
        }

        p {
            color: #555;
            margin-bottom: 15px;
        }

        .game-item,
        .cart-item {
            background-color: #fff;
            padding: 25px;
            margin: 20px 0;
            border-radius: 5px;
            width: 75%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
            text-align: center;
        }

        .game-item:hover,
        .cart-item:hover {
            background-color: #000;
            color: white;
        }

        .logout-link {
            margin-top: 20px;
            display: block;
            text-align: center;
            color: rgb(97, 34, 157);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .logout-link:hover {
            color: rgb(218, 236, 255);
        }

        .game-item img {
            max-width: 100px;
            height: auto;
            margin-bottom: 10px;
            border-radius: 10px;
        }

        .button-link {
            background-color: transparent;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px 20px;
            text-decoration: none;
            color: #fff;
            transition: background-color 0.3s, color 0.3s;
        }

        .button-link:hover {
            background-color: #fff;
            color: #000;
        }

        .clear-cart-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: red;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .clear-cart-link:hover {
            background-color: #8B0000;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #000;
            color: #fff;
            border-radius: 0 0 10px 10px;
        }

        .logo {
            width: 50px;
            height: auto;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 15px 30px;
            background-color: #ff5722;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .back-link:hover {
            background-color: #e64a19;
            transform: translateY(-2px);
        }

        .cart-button {
            background-color: #4CAF50;
            border: none;
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .cart-button:hover {
            background-color: #45a049;
            transform: translateY(-2px);
        }

        /* Стили для формы поиска */
        .search-form {
            margin: 20px 0;
            text-align: center;
        }

        .search-form input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-form input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            margin-left: 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <header>
        <img src="images/logo1.png" alt="Логотип" class="logo">
        <a href="public/public.php" class="button-link">Главная</a>
        <a href="public/cart.php" class="button-link">Корзина</a>
        <a href="public/logout.php" class="logout-link">Выйти</a>
    </header>

    <div class="container">
        <?php if (isset($_SESSION['user'])): ?>
            <h1>Откройте для себя что-то новое, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
        <?php else: ?>
            <h1>Откройте для себя что-то новое!</h1>
        <?php endif; ?>

        <!-- Форма поиска игр по названию -->
        <form class="search-form" action="games_and_cart.php" method="get">
            <input type="text" name="search" placeholder="Введите название игры" value="<?php echo htmlspecialchars($search_keyword); ?>">
            <input type="submit" value="Поиск">
        </form>

        <h2>Список игр:</h2>

        <?php
        // Проверка авторизации
        if (!isset($_SESSION['user_id'])) {
            header("Location: /phpindividual/public/login.php");
            exit();
        }

        $user_id = (int)$_SESSION['user_id'];

        // Получение списка доступных игр с возможностью поиска
        if ($search_keyword !== "") {
            $query = "SELECT id, title, genre, price, image_path, description FROM plays WHERE title LIKE ?";
            $stmt = $conn->prepare($query);
            $like_keyword = "%" . $search_keyword . "%";
            $stmt->bind_param("s", $like_keyword);
        } else {
            $query = "SELECT id, title, genre, price, image_path, description FROM plays";
            $stmt = $conn->prepare($query);
        }

        if ($stmt && $stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                echo "<div class='game-item'>";
                if (!empty($row["image_path"])) {
                    echo "<img src='" . htmlspecialchars($row["image_path"]) . "' alt='" . htmlspecialchars($row["title"]) . "'>";
                }
                echo "<p><strong>Название:</strong> " . htmlspecialchars($row["title"]) . "</p>";
                echo "<p><strong>Жанр:</strong> " . htmlspecialchars($row["genre"]) . "</p>";
                echo "<p><strong>Цена:</strong> $" . htmlspecialchars($row["price"]) . "</p>";
                echo "<p><a class='back-link' href='public/game_detail.php?id=" . (int)$row["id"] . "'>Подробнее</a></p>";
                echo "<form action='games_and_cart.php' method='post'>";
                echo "<input type='hidden' name='game_id' value='" . (int)$row["id"] . "'>";
                echo "<input type='submit' class='cart-button' value='Добавить в корзину'>";
                echo "</form>";
                echo "</div>";
            }
            $stmt->close();
        } else {
            echo "<p>Не удалось загрузить список игр.</p>";
        }

        // Получение игр в корзине пользователя
        $stmt = $conn->prepare("
            SELECT plays.title AS game_title, plays.price AS game_price 
            FROM cart 
            INNER JOIN plays ON cart.game_id = plays.id 
            WHERE cart.user_id = ?
        ");
        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            echo "<h2>Ваши игры в корзине:</h2>";
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='cart-item'>";
                    echo "<p><strong>" . htmlspecialchars($row["game_title"]) . "</strong> — $" . htmlspecialchars($row["game_price"]) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>Корзина пуста.</p>";
            }
            $stmt->close();
        }
        ?>
    </div>
</body>

</html>