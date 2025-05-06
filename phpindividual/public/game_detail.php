<?php

session_start();
include(__DIR__ . '/../src/db_connection.php');

// Проверяем наличие параметра id
if (!isset($_GET['id'])) {
    header("Location: /phpindividual/game_detail.php?id=5");
    exit();
}

$game_id = intval($_GET['id']);

// Подготовка запроса с использованием подготовленного выражения
$stmt = $conn->prepare("SELECT id, title, genre, price, image_path, description, video_url FROM plays WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $game_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $game = $result->fetch_assoc();
} else {
    echo "<div style='text-align:center; margin-top:100px;'>Игра не найдена. <a href='/phpindividual/games_and_cart.php'>Назад</a></div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($game['title']); ?> - Описание</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #ece9e6, #ffffff);
            margin: 0;
            padding: 0;
        }

        .game-detail {
            max-width: 500px;
            max-height: 700px;
            padding: 5px 15px;
            margin: 200px auto;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        /* Overlay для затемнения фона, если используется фоновая картинка */
        .game-detail::before {
            margin-bottom: 10px;
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, rgba(0, 0, 0, 0.5) 100%);
            z-index: 0;
        }

        /* Чтобы содержимое карточки отображалось поверх overlay */
        .game-detail * {
            position: relative;
            z-index: 1;
        }

        .game-detail h1 {
            font-size: 32px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .game-detail img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .game-detail p {
            font-size: 18px;
            line-height: 1.6;
            color: #fff;
            margin-bottom: 15px;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            margin-bottom: 15px;
            padding: 12px 30px;
            background-color: #ff5722;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            border-radius: 25px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .back-link:hover {
            background-color: #e64a19;
            transform: scale(1.05);
        }

        .video-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            /* поместить за контентом */
            overflow: hidden;
        }

        .video-bg iframe {
            width: 100%;
            height: 100%;
            pointer-events: none;
            /* клики проходят сквозь видео */
        }

        .game-title-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            /* расстояние между логотипом и названием */
            margin-bottom: 20px;
        }

        .game-logo {
            margin-right: 5px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="game-detail">
        <?php if (!empty($game['video_url'])): ?>
            <div class="video-bg">
                <iframe src="<?php echo htmlspecialchars($game['video_url']) . '?autoplay=1&controls=1'; ?>"
                    frameborder="0"
                    allow="autoplay; fullscreen"
                    allowfullscreen>
                </iframe>
            </div>
        <?php endif; ?>
        <div class="game-title-container">
            <h1><?php echo htmlspecialchars($game['title']); ?></h1>
        </div>

        <p><strong>Жанр:</strong> <?php echo htmlspecialchars($game['genre']); ?></p>
        <p><strong>Цена:</strong> $<?php echo $game['price']; ?></p>
        <?php if (!empty($game['description'])): ?>
            <p><strong>Описание:</strong> <?php echo nl2br(htmlspecialchars($game['description'])); ?></p>
        <?php else: ?>
            <p>Описание отсутствует.</p>
        <?php endif; ?>
        <div style="text-align: center;">
            <a class="back-link" href="/phpindividual/games_and_cart.php">Назад к играм</a>
        </div>
    </div>
</body>

</html>