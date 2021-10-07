<?php

$db = new PDO('sqlite:../var/db.sqlite');

$postId = $_GET['id'] ?? null;


$statement = $db->query('SELECT * FROM post WHERE id=? LIMIT 1');
$statement->execute([$postId]);

$post = $statement->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    echo '404 not found';
    http_response_code(404);
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>List of Posts</title>
</head>
<body>
<h1><?= $post['title'] ?></h1>
<div><?= $post['author'] ?></div>
<article><?= $post['body'] ?></article>
</body>
</html>
