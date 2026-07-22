<?php
/** @var string $appUrl */
/** @var array $profile */
/** @var bool $isOwn */
/** @var bool $isFollowing */
/** @var int $followersCount */
/** @var int $followingCount */
/** @var list<array> $authoredBooks */
/** @var array $errors */
?>
<section>
    <p class="eyebrow">Perfil</p>
    <h1><?= htmlspecialchars($profile['display_name'], ENT_QUOTES, 'UTF-8') ?></h1>
    <p class="lead">
        @<?= htmlspecialchars($profile['username'], ENT_QUOTES, 'UTF-8') ?>
        · <?= htmlspecialchars($profile['role'], ENT_QUOTES, 'UTF-8') ?>
        · <?= (int) $followersCount ?> seguidores
        · <?= (int) $followingCount ?> siguiendo
    </p>
    <?php if (!empty($profile['bio'])): ?>
        <p><?= nl2br(htmlspecialchars($profile['bio'], ENT_QUOTES, 'UTF-8')) ?></p>
    <?php endif; ?>
</section>

<?php if (!$isOwn): ?>
    <p class="actions">
        <?php if ($isFollowing): ?>
            <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/dejar-seguir/<?= (int) $profile['id'] ?>">
                <?= \App\Core\Csrf::field() ?>
                <button type="submit" class="btn btn-ghost">Dejar de seguir</button>
            </form>
        <?php else: ?>
            <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/seguir/<?= (int) $profile['id'] ?>">
                <?= \App\Core\Csrf::field() ?>
                <button type="submit" class="btn">Seguir</button>
            </form>
        <?php endif; ?>
    </p>
<?php else: ?>
    <section class="stack-section auth-card">
        <h2>Editar perfil</h2>
        <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/perfil" class="form">
            <?= \App\Core\Csrf::field() ?>
            <label>
                Nombre visible
                <input type="text" name="display_name" value="<?= htmlspecialchars($profile['display_name'], ENT_QUOTES, 'UTF-8') ?>" required>
                <?php if (!empty($errors['display_name'])): ?>
                    <span class="field-error"><?= htmlspecialchars($errors['display_name'], ENT_QUOTES, 'UTF-8') ?></span>
                <?php endif; ?>
            </label>
            <label>
                Biografía
                <textarea name="bio" rows="4"><?= htmlspecialchars((string) ($profile['bio'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
                <?php if (!empty($errors['bio'])): ?>
                    <span class="field-error"><?= htmlspecialchars($errors['bio'], ENT_QUOTES, 'UTF-8') ?></span>
                <?php endif; ?>
            </label>
            <button type="submit" class="btn">Guardar</button>
        </form>
    </section>
<?php endif; ?>

<?php if ($authoredBooks !== []): ?>
    <section class="stack-section">
        <h2>Historias publicadas</h2>
        <ul class="card-list">
            <?php foreach ($authoredBooks as $book): ?>
                <li>
                    <a class="card-link" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/libros/<?= (int) $book['id'] ?>">
                        <strong><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></strong>
                        <span><?= htmlspecialchars((string) ($book['genre'] ?? ''), ENT_QUOTES, 'UTF-8') ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
<?php endif; ?>
