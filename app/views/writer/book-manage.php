<?php
/** @var string $appUrl */
/** @var array $book */
/** @var list<array> $chapters */
/** @var array $errors */
?>
<section>
    <p class="eyebrow">Gestionar historia</p>
    <h1><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></h1>
    <p class="lead">Estado actual: <strong><?= htmlspecialchars($book['status'], ENT_QUOTES, 'UTF-8') ?></strong></p>
</section>

<section class="stack-section auth-card" style="max-width:560px">
    <h2>Datos de la historia</h2>
    <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/escribir/libros/<?= (int) $book['id'] ?>" class="form">
        <?= \App\Core\Csrf::field() ?>
        <label>
            Título
            <input type="text" name="title" value="<?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?>" required maxlength="200">
            <?php if (!empty($errors['title'])): ?><span class="field-error"><?= htmlspecialchars($errors['title'], ENT_QUOTES, 'UTF-8') ?></span><?php endif; ?>
        </label>
        <label>
            Género
            <input type="text" name="genre" value="<?= htmlspecialchars((string) ($book['genre'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" maxlength="80">
        </label>
        <label>
            Sinopsis
            <textarea name="synopsis" rows="4"><?= htmlspecialchars((string) ($book['synopsis'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
        </label>
        <label>
            Estado
            <select name="status">
                <?php foreach (['borrador', 'publicado', 'archivado'] as $status): ?>
                    <option value="<?= $status ?>" <?= ($book['status'] ?? '') === $status ? 'selected' : '' ?>><?= $status ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button type="submit" class="btn">Guardar cambios</button>
    </form>
</section>

<section class="stack-section">
    <h2>Capítulos</h2>
    <p class="actions">
        <a class="btn" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/escribir/libros/<?= (int) $book['id'] ?>/capitulos/nuevo">Nuevo capítulo</a>
    </p>
    <?php if ($chapters === []): ?>
        <p class="empty">Todavía no hay capítulos.</p>
    <?php else: ?>
        <ul class="card-list">
            <?php foreach ($chapters as $chapter): ?>
                <li>
                    <a class="card-link" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/escribir/libros/<?= (int) $book['id'] ?>/capitulos/<?= (int) $chapter['id'] ?>/editar">
                        <strong><?= (int) $chapter['number'] ?>. <?= htmlspecialchars($chapter['title'], ENT_QUOTES, 'UTF-8') ?></strong>
                        <span><?= htmlspecialchars($chapter['status'], ENT_QUOTES, 'UTF-8') ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>
