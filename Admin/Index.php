<?php

require '../Includes/Init.php';
Auth::requireLogin();

$conn = require '../Includes/DB.php';

$paginator = new Paginator($_GET['page'] ?? 1, 7, Article::getTotal($conn));
$articles = Article::getPage($conn, $paginator->limit, $paginator->offset);

?>
<?php require '../Includes/header.php'; ?>

<h2>Administration</h2>
<p><a href="New-article.php">New article</a></p>

<?php if (empty($articles)) : ?>
    <p>No articles found.</p>
<?php else : ?>

    <table>
        <thead>
            <th>Titles</th>
            <th>Published</th>
        </thead>
        <tbody>
            <?php foreach ($articles as $article) : ?>
                <tr>
                    <td>
                        <a href="Article.php?id=<?= $article['id']; ?>">
                        <?= htmlspecialchars($article['title']); ?>
                    </td>
                    <td>
                        <?php if ($article['published_at']) : ?>
                            <time><?= $article['published_at'] ?></time>
                        <?php else : ?>
                            Unpublished
                            <button class="publish" data-id="<?= $article['id'] ?>">Publish</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table><br><hr>

    <?php require '../Includes/Pagination.php'; ?>
<?php endif; ?>

<?php require '../Includes/footer.php'; ?>
