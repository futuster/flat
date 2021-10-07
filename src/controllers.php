<?php

use App\Model\Post;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

function list_post_action(): Response
{
    $posts = get_all_posts();

    $html = render_template('../templates/list.php', ['posts' => $posts]);

    return new Response($html);
}

function show_post_action($id): Response
{
    $post = get_post($id);
    if (!$post) {
        $html = '<html lang="en"><body><h1>Page Not Found</h1></body></html>';
        return new Response($html, Response::HTTP_NOT_FOUND);
    }

    $html = render_template('../templates/show.php', ['post' => $post]);

    return new Response($html);
}

function create_post_action(): Response
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

    // $post = Post::create($title, $author, $body);
    // $errors = $validator->validate($post);
    // if($errors->count() === 0)

    // сохранение
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && count($error) === 0) {

        // $post = create_post($post);
        $post = create_post(Post::create($title, $author, $body));

        // редирект на страницу просмотра нового поста
        return new RedirectResponse('/show/?id=' . $post->id);
    }

    $html = render_template('../templates/create.php', ['error' => $error, 'title' => $title, 'author' => $author, 'body' => $body]);

    return new Response($html);
}

function update_post_action($title, $author, $body): Response
{
    // ...
    // валидация
    // сохранение
    // шаблон с формой
    return new Response();
}

// мусор которым обрастает код, в данном случае "хелпер" для рендера шаблонов
function render_template(string $path, array $args): bool|string
{
    extract($args, EXTR_OVERWRITE);
    ob_start();
    require $path;
    return ob_get_clean();
}
