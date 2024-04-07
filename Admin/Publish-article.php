<?php

require '../Includes/Init.php';
Auth::requireLogin();

$conn = require '../Includes/DB.php';
$article = Article::getByID($conn, $_POST['id']);
$published_at = $article->publish($conn);

?><time><?= $published_at ?></time>