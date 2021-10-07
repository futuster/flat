<!DOCTYPE html>
<html>
<head>
    <title>Посты</title>
</head>
<body>
<?php
foreach ($posts as $post) {
    ?>
    <h2><a href="/show/?id=<?= $post->id ?>"><?= $post->title ?></a></h2>
    <div><?= $post->author ?></div>
    <article><?= $post->body ?></article>
    <?php
}
?>
</body>
</html>
