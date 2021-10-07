<?php

$db = new PDO('sqlite:../var/db.sqlite');


$author = trim($_POST['author'] ?? null);
$title = trim($_POST['title'] ?? null);
$body = trim($_POST['body'] ?? null);

$error = [];

// валидация
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($author)) {
        $error['author'] = 'Укажите автора';
    }
    if (empty($title)) {
        $error['title'] = 'Придумайте заголовок';
    }
    if (empty($body)) {
        $error['body'] = 'Напишите пост';
    }
}

// сохранение
if ($_SERVER['REQUEST_METHOD'] === 'POST' && count($error) === 0) {
    $qry = $db->prepare(
        'INSERT INTO post (title, author, body) VALUES (?, ?, ?)'
    );

    $qry->execute([$title, $author, $body]);

    header('Location: /');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Создание нового поста</title>
    <style>
        label span {
            display: block;
        }
        input {
            width: 25%;
            min-width: 400px;
        }

        textarea {
            width: 50%;
            height: 400px;
            min-width: 500px;
        }
    </style>
</head>
<body>
<form method="post">
    <div>
        <label>
            <span>Заголовок</span>
            <input name="title" type="text" value="<?= $title ?>">
            <?php
            if (isset($error['title'])) {
                ?>
                <span style="color: #660000"><?= $error['title'] ?></span>
                <?php
            }
            ?>
        </label>
    </div>
    <div>
        <label>
            <span>Пост</span>
            <textarea name="body"><?= $body ?></textarea>
            <?php
            if (isset($error['body'])) {
                ?>
                <span style="color: #660000"><?= $error['body'] ?></span>
                <?php
            }
            ?>
        </label>
    </div>
    <input name="author" type="hidden" value="admin">
    <div>
        <input type="submit" value="Отправить">
    </div>
</form>
</body>
</html>
