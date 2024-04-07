<?php

require 'Includes/Init.php';
// Auth::requireLogin();
$conn = require 'Includes/Db.php';

if (isset($_GET['id'])) {
    $article = Article::getWithCategories($conn, $_GET['id'], true);
} else {
    $article = null;
}
?>


<?php require 'Includes/header.php'; ?>

<?php if ($article) : ?>

    <article>
        <h2><?= htmlspecialchars($article[0]['title']); ?></h2>

        <time date="<?= $article[0]['published_at'] ?>"><?php
            $datetime = new DateTime($article[0]['published_at']);
            echo $datetime->format("j F, Y");
        ?></time>

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

<?php else : ?>
    <p>Article not found.</p>
<?php endif; ?>

<?php require 'Includes/footer.php'; ?>
