<?php

function db_connect()
{
    return new PDO('sqlite:../var/db.sqlite');
}

function db_disconnect(&$connection)
{
    $connection = null;
}

function get_all_posts()
{
    $connection = db_connect();
    $statement = $connection->query('SELECT * FROM post ORDER BY id DESC');
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
    db_disconnect($connection);
    return $posts;
}

function get_post($id)
{
    $connection = db_connect();
    $statement = $connection->query('SELECT * FROM post WHERE id=? LIMIT 1');
    $statement->execute([$id]);

    $post = $statement->fetch(PDO::FETCH_ASSOC);

    db_disconnect($connection);

    return $post;
}

function create_post($title, $author, $body)
{
    $connection = db_connect();
    $qry = $connection->prepare(
        'INSERT INTO post (title, author, body) VALUES (?, ?, ?)'
    );

    $qry->execute([$title, $author, $body]);

    db_disconnect($connection);
}
