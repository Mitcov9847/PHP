
# Отчёт о выполнении лабораторной работы

## Введение
Данный проект представляет собой веб-приложение для управления рецептами, где пользователи могут добавлять новые рецепты, просматривать уже добавленные, а также взаимодействовать с ними через функционал пагинации. В приложении реализованы функции фильтрации и валидации пользовательского ввода для повышения безопасности и обеспечения корректности данных.

## Описание проекта
Веб-приложение состоит из нескольких страниц, каждая из которых имеет свои функции:

1. **Главная страница** — отображает два последних рецепта.
2. **Страница добавления рецепта** — форма для ввода нового рецепта.
3. **Страница всех рецептов** — отображение всех рецептов с пагинацией.

Приложение использует простую структуру для хранения данных рецептов в текстовом файле, где каждый рецепт представлен как строка JSON.

### валидации данных
- **Фильтрация данных** реализована с помощью функции `sanitize()`, которая очищает ввод от лишних символов, тегов и пробелов.
- **Валидация данных** осуществляется через функцию `validate()`, которая проверяет обязательные поля на наличие данных.

## Структура проекта
Проект состоит из нескольких файлов:
1. **create.php** — форма для добавления нового рецепта.
2. **index.php** — страница отображения всех рецептов.
3. **save_recipe.php** — обработка сохранения рецепта.
4. **helpers.php** — вспомогательные функции для фильтрации и валидации данных.
   
## 🔧 Цель проекта

Разработка веб-приложения на PHP для хранения и отображения кулинарных рецептов. Пользователи могут:

- добавлять рецепты через форму;
- просматривать последние рецепты на главной странице;
- просматривать все рецепты с пагинацией;
- получать подробную информацию о каждом рецепте.

## 📄 Файл `storage/recipes.txt`

Хранит рецепты в формате JSON, по одному объекту на строку. Пример одной строки:

```json
{"title":"Борщ","category":"Супы","description":"Классический борщ.","ingredients":"Свекла, капуста, мясо...","steps":["Нарезать овощи", "Отварить мясо", "Добавить специи"],"tags":["украинская кухня","обед"],"created_at":"2025-04-22 14:30:00"}
```

---

## 🏠 Главная страница `index.php`

**Функциональность**:
- Загружает последние 2 рецепта;
- Безопасно выводит заголовок, категорию и описание;
- Отображает сообщение, если рецептов нет.

**Ключевые особенности**:
- `json_decode()` преобразует JSON-строки в объекты;
- `htmlspecialchars()` защищает от XSS;
- Эстетичное оформление с помощью встроенного CSS.
![image](https://github.com/user-attachments/assets/ef268027-ef93-4786-8076-fe3bb2405e39)
---

## 📋 Страница всех рецептов `recipe/index.php`

**Функциональность**:
- Загружает все рецепты из файла;
- Отображает по 5 рецептов на страницу;
- Поддержка параметра `page` через GET;
- Постраничная навигация.

**Ключевые особенности**:
- `array_slice()` реализует пагинацию;
- Все поля (включая шаги, теги и дату) отображаются;
- Удобная навигация между страницами.
![image](https://github.com/user-attachments/assets/d1e67b90-2507-4e05-be6c-b53ee192233b)
![image](https://github.com/user-attachments/assets/e3f9e834-1d59-4317-a3fb-f0910ed2acf7)

---

## 📝 Страница создания рецепта `recipe/create.php`

**Функциональность**:
- Форма с полями: название, категория, ингредиенты, описание, шаги, теги;
- Валидация данных;
- Сохранение в `recipes.txt` в формате JSON;
- Перенаправление после успешного добавления.

**Особенности**:
- Поддержка многострочных полей;
- `explode()` для парсинга шагов и тегов;
- `json_encode()` для хранения.
- 
![image](https://github.com/user-attachments/assets/b286ad05-58c6-46b5-b5ea-ab5fdaee0083)
---

Функциональность
Получение параметра page:
Берет $_GET['page'] или устанавливает 'index' по умолчанию.
Маршрутизация:
Через switch подключает файлы:
create: src/handlers/recipe/create.php — создание рецепта.
show: src/handlers/recipe/show.php — просмотр рецепта.
edit: src/handlers/recipe/edit.php — редактирование рецепта.
delete: src/handlers/recipe/delete.php — удаление рецепта.
default: templates/index.php — главная страница.
Модульность:
Использует require_once, разделяя логику и представление.

**`public/index.php`**

```php
<?php
/**
 * @file index.php
 * @description Главная страница с последними рецептами.
 */

$filepath = __DIR__ . '/../storage/recipes.txt';
$recipes = [];

if (file_exists($filepath)) {
    $lines = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $recipes = array_reverse(array_map('json_decode', $lines));
    $latest = array_slice($recipes, 0, 2);
} else {
    $latest = [];
}
?>

<head>
    <meta charset="UTF-8">
    <title>Каталог рецептов</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 2rem;
        }
        h1 {
            margin-bottom: 1rem;
        }
        .recipe {
            border-bottom: 1px solid #ccc;
            padding: 1rem 0;
        }
        .recipe h3 {
            margin: 0.2em 0;
        }
        .recipe p {
            margin: 0.3em 0;
        }
        .links {
            margin-top: 2rem;
        }
        .links a {
            display: inline-block;
            margin-right: 1rem;
            text-decoration: none;
            color: #0077cc;
        }
    </style>
</head>
<body>

<h1>Последние рецепты</h1>

<?php if (empty($latest)): ?>
    <p>Пока нет рецептов.</p>
<?php else: ?>
    <?php foreach ($latest as $recipe): ?>
        <div class="recipe">
            <h3><?= htmlspecialchars($recipe->title) ?></h3>
            <p><strong>Категория:</strong> <?= htmlspecialchars($recipe->category) ?></p>
            <p><strong>Описание:</strong><br><?= nl2br(htmlspecialchars($recipe->description)) ?></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<div class="links">
    <a href="/recipe/create.php">➕ Добавить новый рецепт</a>
    <a href="/recipe/index.php">📋 Все рецепты</a>
</div>

```
index.php — главная страница, показывает два последних рецепта из storage/recipes.txt (JSON-объекты с title, category, description). PHP читает файл, декодирует строки, переворачивает порядок, берет первые два. HTML с CSS выводит рецепты, экранируя данные (htmlspecialchars, nl2br). Если рецептов нет — "Пока нет рецептов". Ссылки: /recipe/create.php (добавить) и /recipe/index.php (все рецепты). Простой код, улучшаемый проверкой JSON или кэшированием.

**`src/helpers.php`**

```<?php
/**
 * @file helpers.php
 * @brief Утилиты для работы с рецептами: фильтрация и проверка данных формы.
 *
 * Включает:
 * - cleanInput() — удаляет лишние символы из строки
 * - checkRecipeForm() — проводит базовую валидацию формы рецепта
 *
 * Используется в: save_recipe.php
 */

/**
 * Приводит входную строку к безопасному виду
 *
 * @param string $input
 * @return string
 */
function cleanInput(string $input): string {
    return htmlspecialchars(trim(strip_tags($input)));
}

/**
 * Проверяет корректность данных рецепта
 *
 * @param array $form
 * @return array список найденных ошибок
 */
function checkRecipeForm(array $form): array {
    $issues = [];

    $requiredFields = [
        'title' => 'Укажите название рецепта',
        'category' => 'Категория обязательна',
        'ingredients' => 'Перечислите ингредиенты',
        'description' => 'Добавьте описание',
    ];

    foreach ($requiredFields as $field => $message) {
        if (empty($form[$field])) {
            $issues[$field] = $message;
        }
    }

    if (!isset($form['steps']) || !is_array($form['steps']) || count(array_filter($form['steps'])) === 0) {
        $issues['steps'] = 'Требуется хотя бы один шаг приготовления';
    }

    return $issues;
}

Файл helpers.php содержит утилиты для работы с рецептами. Функция cleanInput очищает строку, удаляя теги (strip_tags), пробелы (trim) и экранируя символы (htmlspecialchars) для защиты от XSS. Функция checkRecipeForm валидирует данные формы рецепта, проверяя обязательные поля (title, category, ingredients, description) и наличие хотя бы одного шага (steps) в массиве. Возвращает массив ошибок, если поля пусты или шаги отсутствуют. Используется в save_recipe.php для безопасной обработки данных.
```

**`handlers/save_recipe.php`**

```<?php
/**
 * @file save_recipe.php
 * @brief Обработчик формы добавления рецепта.
 *
 * Получает данные из формы (POST), выполняет:
 * - фильтрацию и очистку данных;
 * - валидацию обязательных полей;
 * - сохранение валидных данных в файл storage/recipes.txt в формате JSON;
 * - сохранение ошибок и возврат на форму при неудаче;
 * - перенаправление на главную при успехе.
 *
 * Использует:
 * - cleanInput() и checkRecipeForm() из helpers.php
 * - session для передачи ошибок и старых значений
 */

ob_start(); 
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

require_once __DIR__ . '/../../src/helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Очистка данных
    $title = cleanInput($_POST['title'] ?? '');
    $category = cleanInput($_POST['category'] ?? '');
    $ingredients = cleanInput($_POST['ingredients'] ?? '');
    $description = cleanInput($_POST['description'] ?? '');
    $tags = $_POST['tags'] ?? [];

    // Обработка шагов
    $stepsRaw = $_POST['steps'] ?? [];
    $steps = array_filter(array_map('cleanInput', $stepsRaw));

    // Сбор всех данных
    $formData = [
        'title' => $title,
        'category' => $category,
        'ingredients' => $ingredients,
        'description' => $description,
        'tags' => $tags,
        'steps' => $steps,
        'created_at' => date('Y-m-d H:i:s')
    ];

    // Валидация
    $errors = checkRecipeForm($formData);

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $_POST;
        header('Location: ../../public/recipe/create.php');
        exit;
    }

    // Сохранение в файл
    $line = json_encode($formData, JSON_UNESCAPED_UNICODE) . PHP_EOL;
    file_put_contents(__DIR__ . '/../../storage/recipes.txt', $line, FILE_APPEND);

    header('Location: ../../public/index.php');
    exit;
}

Файл save_recipe.php обрабатывает POST-данные формы добавления рецепта. Включает helpers.php для использования cleanInput и checkRecipeForm. Очищает поля (title, category, ingredients, description, steps) через cleanInput, фильтрует шаги, собирает данные в массив с тегами и датой создания. Валидирует форму через checkRecipeForm. Если есть ошибки, сохраняет их и старые данные в сессию, перенаправляя на create.php. При успехе записывает данные в recipes.txt как JSON-строку и перенаправляет на главную (index.php). Использует ob_start и сессии для управления выводом и ошибками.
```

**`recipe/create.php`**

<?php
/**
 * @file create.php
 * @description Интерфейс добавления нового рецепта в приложение.
 *
 * Использует сессию для передачи ошибок и сохранения данных пользователя при ошибке.
 */
session_start();

$formErrors = $_SESSION['errors'] ?? [];
$formData = $_SESSION['old'] ?? [];

unset($_SESSION['errors'], $_SESSION['old']);

?>

<form action="/handlers/save_recipe.php" method="post">
    <div class="form-group">
        <label for="title">Название рецепта:</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($formData['title'] ?? '') ?>" placeholder="Например, Блины с творогом">
        <?php if (!empty($formErrors['title'])): ?>
            <div class="error-message"><?= $formErrors['title'] ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="category">Категория:</label>
        <select id="category" name="category">
            <option value="">-- Выберите категорию --</option>
            <?php foreach (['Супы', 'Салаты', 'Десерты'] as $option): ?>
                <option value="<?= $option ?>" <?= ($formData['category'] ?? '') === $option ? 'selected' : '' ?>>
                    <?= $option ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($formErrors['category'])): ?>
            <div class="error-message"><?= $formErrors['category'] ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="ingredients">Ингредиенты:</label>
        <textarea id="ingredients" name="ingredients" rows="4" placeholder="Список ингредиентов через запятую"><?= htmlspecialchars($formData['ingredients'] ?? '') ?></textarea>
        <?php if (!empty($formErrors['ingredients'])): ?>
            <div class="error-message"><?= $formErrors['ingredients'] ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="description">Описание:</label>
        <textarea id="description" name="description" rows="3" placeholder="Краткое описание рецепта"><?= htmlspecialchars($formData['description'] ?? '') ?></textarea>
        <?php if (!empty($formErrors['description'])): ?>
            <div class="error-message"><?= $formErrors['description'] ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="tags">Теги:</label>
        <select name="tags[]" id="tags" multiple size="4">
            <?php foreach (['Веган', 'Безглютеновый', 'Праздничный', 'Быстрый'] as $tag): ?>
                <option value="<?= $tag ?>" <?= in_array($tag, $formData['tags'] ?? []) ? 'selected' : '' ?>><?= $tag ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Шаги приготовления:</label>
        <div id="steps-wrapper">
            <?php foreach ($formData['steps'] ?? [''] as $instruction): ?>
                <input type="text" name="steps[]" value="<?= htmlspecialchars($instruction) ?>" placeholder="Опишите шаг..." required>
            <?php endforeach; ?>
        </div>
        <?php if (!empty($formErrors['steps'])): ?>
            <div class="error-message"><?= $formErrors['steps'] ?></div>
        <?php endif; ?>
        <button type="button" id="add-step-btn">+ Добавить шаг</button>
    </div>

    <button type="submit">Сохранить рецепт</button>
</form>

```
document.getElementById('add-step-btn').addEventListener('click', () => {
    const stepField = document.createElement('input');
    stepField.type = 'text';
    stepField.name = 'steps[]';
    stepField.placeholder = 'Опишите шаг...';
    stepField.required = true;
    document.getElementById('steps-wrapper').appendChild(stepField);
});
```

Этот JavaScript-код добавляет динамическое поле для ввода шагов приготовления в форму на странице create.php. При клике на кнопку с id="add-step-btn" создаётся новый текстовый <input> с именем steps[] (для отправки массива шагов), плейсхолдером "Опишите шаг..." и атрибутом required. Поле добавляется в контейнер с id="steps-wrapper".

Файл create.php — интерфейс для добавления нового рецепта. Использует сессию для отображения ошибок ($_SESSION['errors']) и старых данных ($_SESSION['old']), очищая их после использования. HTML-форма отправляет POST-запрос на /handlers/save_recipe.php с полями: title (текст), category (выбор из Супы/Салаты/Десерты), ingredients и description (текстовые области), tags (множественный выбор: Веган/Безглютеновый и др.), steps (массив текстовых полей). Ошибки валидации отображаются под полями. CSS-стили оформляют форму, JavaScript добавляет новые поля для шагов по клику на кнопку. Данные экранируются через htmlspecialchars для безопасности.

**`recipe/index.php`**
```
<?php
/**
 * @file index.php
 * @description Страница со списком рецептов и постраничной навигацией.
 */

$filepath = __DIR__ . '/../../storage/recipes.txt';
$recipes = [];

if (file_exists($filepath)) {
    $lines = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $recipes = array_reverse(array_map('json_decode', $lines));
}

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 5;
$total = count($recipes);
$totalPages = ceil($total / $perPage);
$offset = ($page - 1) * $perPage;
$currentRecipes = array_slice($recipes, $offset, $perPage);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список рецептов</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 2rem;
        }
        .recipe {
            border-bottom: 1px solid #ccc;
            padding: 1rem 0;
        }
        .recipe h3 {
            margin: 0.2em 0;
        }
        .recipe p, .recipe ol {
            margin: 0.3em 0;
        }
        .pagination a, .pagination strong {
            margin: 0 5px;
            text-decoration: none;
        }
        .pagination {
            margin-top: 2rem;
        }
    </style>
</head>
<body>

<h1>Рецепты (страница <?= $page ?>)</h1>

<?php if (empty($currentRecipes)): ?>
    <p>На этой странице рецептов нет.</p>
<?php else: ?>
    <?php foreach ($currentRecipes as $recipe): ?>
        <div class="recipe">
            <h3><?= htmlspecialchars($recipe->title) ?></h3>
            <p><strong>Категория:</strong> <?= htmlspecialchars($recipe->category) ?></p>
            <p><strong>Ингредиенты:</strong><br><?= nl2br(htmlspecialchars($recipe->ingredients)) ?></p>
            <p><strong>Описание:</strong><br><?= nl2br(htmlspecialchars($recipe->description)) ?></p>
            <p><strong>Шаги приготовления:</strong></p>
            <ol>
                <?php foreach ($recipe->steps as $step): ?>
                    <li><?= htmlspecialchars($step) ?></li>
                <?php endforeach; ?>
            </ol>
            <?php if (!empty($recipe->tags)): ?>
                <p><strong>Теги:</strong> <?= implode(', ', array_map('htmlspecialchars', $recipe->tags)) ?></p>
            <?php endif; ?>
            <p><em>Добавлено: <?= htmlspecialchars($recipe->created_at) ?></em></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<!-- Навигация по страницам -->
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>">&laquo; Назад</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <?php if ($i === $page): ?>
            <strong>[<?= $i ?>]</strong>
        <?php else: ?>
            <a href="?page=<?= $i ?>"><?= $i ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page + 1 ?>">Вперёд &raquo;</a>
    <?php endif; ?>
</div>

<p><a href="/index.php">На главную</a></p>

Файл index.php отображает список всех рецептов из storage/recipes.txt с постраничной навигацией. PHP-логика читает файл, декодирует JSON-строки в объекты, переворачивает порядок (новые первыми). Пагинация: GET-параметр page определяет текущую страницу (мин. 1), по 5 рецептов на страницу, вычисляются общее число страниц и смещение. HTML с CSS выводит рецепты (title, category, ingredients, description, steps, tags, created_at), экранируя данные через htmlspecialchars и форматируя переносы (nl2br). Если рецептов нет, показывается сообщение. Пагинация включает ссылки "Назад", номера страниц и "Вперёд". Ссылка ведёт на главную (/index.php).

```

## Ответы на контрольные вопросы

### Какие методы HTTP применяются для отправки данных формы?
В PHP формы могут отправляться с помощью методов GET и POST. Метод GET передаёт данные через URL и чаще используется для получения информации. Однако, он не подходит для передачи конфиденциальных данных, так как всё видно в адресной строке. Метод POST, напротив, передаёт данные в теле запроса, что делает его более безопасным и подходящим для отправки форм, где требуется обработка и сохранение пользовательских данных. В моём проекте я использую метод POST, так как форма передаёт пользовательский ввод, который нужно обработать и сохранить.

### Что такое валидация и чем она отличается от фильтрации?
Фильтрация — это процесс очистки данных от ненужных символов, HTML-тегов и пробелов, чтобы предотвратить внедрение вредоносного кода (например, XSS-атак). Валидация, в свою очередь, проверяет данные на соответствие определённым правилам, например, проверка обязательных полей, допустимых значений и т.д. В моём проекте я реализовал фильтрацию данных через функцию sanitize(), которая очищает ввод от лишних символов, а валидацию — через функцию validate(), которая проверяет обязательные поля и правильность введённых данных.

### Какие функции PHP используются для фильтрации данных?
В проекте я использую несколько функций PHP для фильтрации данных:
- `trim()` — удаляет пробелы в начале и конце строки;
- `strip_tags()` — удаляет все HTML и PHP теги из строки;
- `htmlspecialchars()` — преобразует специальные символы в их HTML-сущности, например, `<` превращается в `&lt;`.

Эти функции работают в связке внутри функции `sanitize()`, чтобы обеспечить безопасность данных перед их сохранением и отображением на веб-странице.

### Выводы
В ходе разработки веб-приложения для управления рецептами были успешно реализованы основные функциональные возможности, включая добавление рецептов, их сохранение и отображение с пагинацией. Особое внимание было уделено безопасности данных, для чего применялись фильтрация и валидация ввода. Это позволяет обеспечить защиту от возможных уязвимостей, таких как XSS-атаки.

Также важно отметить использование методов HTTP для обработки данных формы. Метод POST был выбран для отправки данных формы, так как он безопаснее GET и подходит для работы с пользовательскими данными.

## Библиография
- PHP Manual. (2025). https://www.php.net/manual/en/
- W3Schools. (2025). PHP Forms. https://www.w3schools.com/php/php_forms.asp
- MDN Web Docs. (2025). HTML Forms. https://developer.mozilla.org/en-US/docs/Web/HTML/Element/form
