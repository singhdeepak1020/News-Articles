<?php

require '../Includes/Init.php';

Auth::requireLogin();
$article = new Article();

$category_ids = [];
$conn = require '../Includes/DB.php';
$categories = Category::getAll($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $article->title = $_POST['title'];
    $article->content = $_POST['content'];
    $article->published_at = $_POST['published_at'];

    $category_ids = $_POST['category'] ?? [];

    if ($article->create($conn)) {

        $article->setCategories($conn, $category_ids);
        Url::redirect("/../Class Method/Admin/Article.php?id={$article->id}");

    }
}

?>
<?php require '../Includes/header.php'; ?>

<h2>New article</h2>

<?php require 'Includes/Article-form.php'; ?>

<?php require '../Includes/footer.php'; ?>
