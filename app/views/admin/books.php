<?php
/** @var string $appUrl */
/** @var string $query */
/** @var list<array> $books */
?>
<section>
    <p class="eyebrow">Admin</p>
    <h1>Moderación de contenido</h1>
    <p class="lead">Archiva historias inapropiadas o vuelve a publicarlas.</p>
    <form class="search-form" method="get" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/admin/contenido">
        <input type="search" name="q" value="<?= htmlspecialchars($query, ENT_QUOTES, 'UTF-8') ?>" placeholder="Buscar por título o autor">
        <button type="submit" class="btn">Buscar</button>
    </form>
</section>

<?php if ($books === []): ?>
    <p class="empty">No hay historias para mostrar.</p>
<?php else: ?>
    <ul class="card-list">
        <?php foreach ($books as $book): ?>
            <li class="card-row">
                <div class="card-link">
                    <strong><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></strong>
                    <span>
                        <?= htmlspecialchars($book['author_name'], ENT_QUOTES, 'UTF-8') ?>
                        · <?= htmlspecialchars($book['status'], ENT_QUOTES, 'UTF-8') ?>
                        · <?= htmlspecialchars((string) ($book['genre'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                    </span>
                </div>
                <div class="inline-tools">
                    <?php if ($book['status'] !== 'archivado'): ?>
                        <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/admin/contenido/<?= (int) $book['id'] ?>/archivar">
                            <?= \App\Core\Csrf::field() ?>
                            <button type="submit" class="btn btn-ghost btn-small">Archivar</button>
                        </form>
                    <?php endif; ?>
                    <?php if ($book['status'] !== 'publicado'): ?>
                        <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/admin/contenido/<?= (int) $book['id'] ?>/publicar">
                            <?= \App\Core\Csrf::field() ?>
                            <button type="submit" class="btn btn-small">Publicar</button>
                        </form>
                    <?php endif; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
