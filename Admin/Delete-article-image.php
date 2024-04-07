<?php

require '../Includes/Init.php';
Auth::requireLogin();
$conn = require '../Includes/DB.php';

if (isset($_GET['id'])) {

    $article = Article::getByID($conn, $_GET['id']);

    if ( ! $article) {
        die("article not found");
    }

} else {
    die("id not supplied, article not found");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $previous_image = $article->image_file;

    if ($article->setImageFile($conn, null)) {

        if ($previous_image) {
            unlink("../Uploads/$previous_image");
        }

        URL::redirect("/../Class Method/Admin/Edit-article-image.php?id={$article->id}");
    }
}

?>
<?php require '../Includes/header.php'; ?>

<h2>Delete article image</h2>

<?php if ($article->image_file) : ?>
    <img src="/../Class Method/Uploads/<?= $article->image_file; ?>" width="200px">
<?php endif; ?>

<form method="post">

    <p>Are you sure?</p>

    <button>Delete</button>
    <a href="Edit-article-image.php?id=<?= $article->id; ?>">Cancel</a>
</form>

<?php require '../Includes/footer.php'; ?>
