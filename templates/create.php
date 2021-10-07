<?php

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
