<?php
// Определяем текущий день недели (1 - Пн, 7 - Вс)
$dayOfWeek = date('4');

// Функция для определения графика работы
function getSchedule($employee)
{
    global $dayOfWeek;

    if ($employee === 'John Styles') {
        return in_array($dayOfWeek, [1, 3, 5]) ? '08:00 - 12:00' : 'Нерабочий день';
    } elseif ($employee === 'Jane Doe') {
        return in_array($dayOfWeek, [2, 4, 6]) ? '12:00 - 16:00' : 'Нерабочий день';
    }
    return 'Неизвестный сотрудник';
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <link rel="stylesheet" href="/style/style.css">

    <meta charset="UTF-8">
    <title>Лабораторная работа №2</title>

</head>

<body>

    <h2 class="h2_block">Расписание работы</h2>
    <div class="container_table">
        <table border="2" class="table-style">

            <tr style="background-color: purple;">
                <th>№</th>
                <th>Фамилия Имя</th>
                <th>График работы</th>
            </tr>


            <tr>
                <td>1</td>
                <td>John Styles</td>
                <td><?php echo getSchedule('John Styles'); ?></td>
            </tr>

            <tr>
                <td>2</td>
                <td>Jane Doe</td>
                <td><?php echo getSchedule('Jane Doe'); ?></td>
            </tr>

        </table>
    </div>

    <div class="container_block">
        <h2 class="h2_block">

            Циклы
        </h2>


        <div class="block_h3">

            <h3>Цикл for:</h3>
            <?php
            $a = 0;
            $b = 0;
            for ($i = 0; $i <= 5; $i++) {
                $a += 10;
                $b += 5;
                echo "Шаг $i: a = $a, b = $b<br>";
            }
            ?>
        </div>

        <div class="block_h3">
            <h3>Цикл while:</h3>
            <?php
            $a = 0;
            $b = 0;
            $i = 0;
            while ($i <= 5) {
                $a += 10;
                $b += 5;
                echo "Шаг $i: a = $a, b = $b<br>";
                $i++;
            }
            ?>
        </div>
        <div class="block_h3">
            <h3>Цикл do-while:</h3>
            <?php
            $a = 0;
            $b = 0;
            $i = 0;
            do {
                $a += 10;
                $b += 5;
                echo "Шаг $i: a = $a, b = $b<br>";
                $i++;
            } while ($i <= 5);
            ?>
        </div>
    </div>
</body>

</html>