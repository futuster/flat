<?php

$db = new PDO('sqlite:../var/db.sqlite');

$statement = $db->query('SELECT * FROM post');
$results = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Посты</title>
</head>
<body>
<?php
foreach ($results as $row) {
    ?>
    <h2><a href="/show.php?id=<?= $row['id'] ?>"><?= $row['title'] ?></a></h2>
    <div><?= $row['author'] ?></div>
    <article><?= $row['body'] ?></article>
    <?php
}
?>
</body>
</html>
