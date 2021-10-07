<?php

use App\Model\Post;

function db_connect(): PDO
{
    return new PDO('sqlite:../var/db.sqlite');
}

function db_disconnect(?PDO &$connection)
{
    $connection = null;
}

/**
 * @return Post[]
 */
function get_all_posts(): array
{
    $connection = db_connect();
    $statement = $connection->query('SELECT * FROM post ORDER BY id DESC');
    $postsArray = $statement->fetchAll(PDO::FETCH_ASSOC);
    $posts = [];
    foreach ($postsArray as $postArray) {
        $posts[] = Post::create($postArray['title'], $postArray['author'], $postArray['body'], $postArray['id']);
    }
    db_disconnect($connection);
    return $posts;
}

function get_post(string $id): Post
{
    $connection = db_connect();
    $statement = $connection->query('SELECT * FROM post WHERE id=? LIMIT 1');
    $statement->execute([$id]);

    $postArray = $statement->fetch(PDO::FETCH_ASSOC);

    $post = Post::create($postArray['title'], $postArray['author'], $postArray['body'], $postArray['id']);

    db_disconnect($connection);

    return $post;
}

function create_post(Post $post): Post
{
    $connection = db_connect();
    $qry = $connection->prepare(
        'INSERT INTO post (title, author, body) VALUES (?, ?, ?)'
    );

    $qry->execute([$post->title, $post->author, $post->body]);

    $id = $connection->lastInsertId();
    $post->id = $id;

    db_disconnect($connection);

    return $post;
}
