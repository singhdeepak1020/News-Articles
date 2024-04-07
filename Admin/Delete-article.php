<?php

require '../Includes/Init.php';
Auth::requireLogin();
$conn = require '../Includes/Db.php';

if (isset($_GET['id'])) {

    $article = Article::getByID($conn, $_GET['id']);

    if ( ! $article) {
        die("article not found");
    }

} else {
    die("id not supplied, article not found");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($article->delete($conn)) {

        Url::redirect("/../Class Method/Admin/Index.php");

    }
}

?>
<?php require '../Includes/header.php'; ?>

<h2>Delete article</h2>

    <form method="post">

        <p>Are you sure?</p>

        <button>Delete</button>
        <a href="Article.php?id=<?= $article->id; ?>">Cancel</a>

    </form>

<?php require '../Includes/footer.php'; ?>
