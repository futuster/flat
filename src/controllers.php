<?php

function list_post_action()
{
    $posts = get_all_posts();
    require_once '../templates/list.php';
    exit;
}

function show_post_action($id)
{
    $post = get_post($id);
    if (!$post) {
        header('HTTP/1.1 404 Not Found');
        echo '<html><body><h1>Page Not Found</h1></body></html>';
        exit;
    }
    require_once '../templates/show.php';
    exit;
}

function create_post_action()
{
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
        create_post($title, $author, $body);
        header('Location: /');
        exit;
    }

    require_once '../templates/create.php';
    exit;
}

function update_post_action($title, $author, $body){
    // ...
    // валидация
    // сохранение
    // шаблон с формой
}
