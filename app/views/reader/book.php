<?php
/** @var string $appUrl */
/** @var array $book */
/** @var list<array> $chapters */
/** @var bool $inLibrary */
/** @var bool $isFollowing */
/** @var bool $isOwnAuthor */
?>
<section>
    <p class="eyebrow"><?= htmlspecialchars((string) ($book['genre'] ?? 'Historia'), ENT_QUOTES, 'UTF-8') ?></p>
    <h1><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></h1>
    <p class="lead">
        Por
        <a href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/u/<?= htmlspecialchars(rawurlencode($book['author_username']), ENT_QUOTES, 'UTF-8') ?>">
            <?= htmlspecialchars($book['author_name'], ENT_QUOTES, 'UTF-8') ?>
        </a>
    </p>
    <?php if (!empty($book['synopsis'])): ?>
        <p><?= nl2br(htmlspecialchars($book['synopsis'], ENT_QUOTES, 'UTF-8')) ?></p>
    <?php endif; ?>
</section>

<p class="actions">
    <?php if ($inLibrary): ?>
        <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/biblioteca/quitar/<?= (int) $book['id'] ?>">
            <?= \App\Core\Csrf::field() ?>
            <button type="submit" class="btn btn-ghost">Quitar de biblioteca</button>
        </form>
    <?php else: ?>
        <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/biblioteca/agregar/<?= (int) $book['id'] ?>">
            <?= \App\Core\Csrf::field() ?>
            <button type="submit" class="btn">Guardar en biblioteca</button>
        </form>
    <?php endif; ?>

    <?php if (!$isOwnAuthor): ?>
        <?php if ($isFollowing): ?>
            <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/dejar-seguir/<?= (int) $book['author_user_id'] ?>">
                <?= \App\Core\Csrf::field() ?>
                <button type="submit" class="btn btn-ghost">Dejar de seguir autor</button>
            </form>
        <?php else: ?>
            <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/seguir/<?= (int) $book['author_user_id'] ?>">
                <?= \App\Core\Csrf::field() ?>
                <button type="submit" class="btn btn-ghost">Seguir autor</button>
            </form>
        <?php endif; ?>
    <?php endif; ?>
</p>

<section class="stack-section">
    <h2>Capítulos</h2>
    <?php if ($chapters === []): ?>
        <p class="empty">Esta historia aún no tiene capítulos publicados.</p>
    <?php else: ?>
        <ul class="card-list">
            <?php foreach ($chapters as $chapter): ?>
                <li>
                    <a class="card-link" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/libros/<?= (int) $book['id'] ?>/capitulos/<?= (int) $chapter['id'] ?>">
                        <strong><?= (int) $chapter['number'] ?>. <?= htmlspecialchars($chapter['title'], ENT_QUOTES, 'UTF-8') ?></strong>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>
