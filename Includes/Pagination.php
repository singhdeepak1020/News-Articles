<?php $base = strtok($_SERVER["REQUEST_URI"], '?'); ?>

<nav>
    <ul>
        <li class="change-page">
            <?php if ($paginator->previous): ?>
                <a href="<?= $base; ?>?page=<?= $paginator->previous; ?>"><< Previous Page</a>
            <?php else: ?>
                <div class="change-page">Previous Page</div>
            <?php endif; ?>
        </li>

        <li class="change-page">
            <?php if ($paginator->next): ?>
                <a href="<?= $base; ?>?page=<?= $paginator->next; ?>">Next Page >></a>
            <?php else: ?>
                <div class="change-page">Next Page</div>
            <?php endif; ?>
        </li>
    </ul>
</nav>