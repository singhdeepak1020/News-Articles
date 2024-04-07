<?php

require 'Includes/Init.php';
$conn = require 'Includes/DB.php';

$paginator = new Paginator($_GET['page'] ?? 1, 4, Article::getTotal($conn, true));

$articles = Article::getPage($conn, $paginator->limit, $paginator->offset, true);

?>
<?php require 'Includes/header.php'; ?>

<?php if (empty($articles)) : ?>
    <p class="text">No articles found.</p>
<?php else : ?>

    <ul>
        <?php foreach ($articles as $article) : ?>
            <li>
                <article>
                    <h2><a href="Article.php?id=<?= $article['id']; ?>"><?= htmlspecialchars($article['title']); ?></a></h2>
                    
                    <date  class="text" date="<?= $article['published_at'] ?>"><?php
                        $datetime = new DateTime($article['published_at']);
                        echo $datetime->format("j F, Y");
                    ?></date>

                    <?php if ($article['category_names']) : ?>
                        <p class="text">Categories:
                            <?php foreach ($article['category_names'] as $name) : ?>
                                <?= htmlspecialchars($name); ?>
                            <?php endforeach; ?>
                        </p>
                    <?php endif; ?>
                    
                    <p class="text"><?= htmlspecialchars($article['content']); ?></p>
                </article>
            </li>
        <?php endforeach; ?>
    </ul><hr>

<?php require 'Includes/Pagination.php'; ?>
    
<?php endif; ?>

<?php require 'Includes/footer.php'; ?>
