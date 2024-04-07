<?php

require '../Includes/Init.php';
Auth::requireLogin();
$conn = require '../Includes/DB.php';

if (isset($_GET['id'])) {
    $article = Article::getWithCategories($conn, $_GET['id']);
} else {
    $article = null;
}

?>
<?php require '../Includes/header.php'; ?>

<?php if ($article) : ?>

    <article>
        <h2><?= htmlspecialchars($article[0]['title']); ?></h2>

        <?php if ($article[0]['published_at']) : ?>
            <time><?= $article[0]['published_at'] ?></time>
        <?php else : ?>
            Unpublished
        <?php endif; ?>

        <?php if ($article[0]['category_name']) : ?>
            <p>Category:
                <?php foreach ($article as $a) : ?>
                    <?= htmlspecialchars($a['category_name']); ?>
                <?php endforeach; ?>
            </p>
        <?php endif; ?>

        <?php if ($article[0]['image_file']) : ?>
            <img src="/../Class Method/Uploads/<?= $article[0]['image_file']; ?>" width="200px">
        <?php endif; ?>

        <p><?= htmlspecialchars($article[0]['content']); ?></p>
    </article>

    <a href="Edit-article.php?id=<?= $article[0]['id']; ?>">Edit</a>
    <a class="delete" href="Delete-article.php?id=<?= $article[0]['id']; ?>">Delete</a>
    <a href="Edit-article-image.php?id=<?= $article[0]['id']; ?>">Image</a>

<?php else : ?>
    <p>Article not found.</p>
<?php endif; ?>

<?php require '../Includes/footer.php'; ?>