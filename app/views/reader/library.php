<?php
/** @var string $appUrl */
/** @var list<array> $books */
?>
<section>
    <p class="eyebrow">Biblioteca</p>
    <h1>Tus historias guardadas</h1>
    <p class="lead">Aquí aparecen las obras que agregaste desde Descubrir o la ficha de cada libro.</p>
</section>

<?php if ($books === []): ?>
    <p class="empty">Tu biblioteca está vacía. <a href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/descubrir">Descubre historias</a>.</p>
<?php else: ?>
    <ul class="card-list">
        <?php foreach ($books as $book): ?>
            <li class="card-row">
                <a class="card-link" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/libros/<?= (int) $book['id'] ?>">
                    <strong><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></strong>
                    <span><?= htmlspecialchars($book['author_name'], ENT_QUOTES, 'UTF-8') ?></span>
                </a>
                <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/biblioteca/quitar/<?= (int) $book['id'] ?>">
                    <?= \App\Core\Csrf::field() ?>
                    <button type="submit" class="btn btn-ghost btn-small">Quitar</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
