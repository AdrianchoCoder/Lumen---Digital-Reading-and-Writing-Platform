<?php
/** @var string $appUrl */
/** @var string $mode */
/** @var array $book */
/** @var array $errors */
$isEdit = false;
?>
<section>
    <p class="eyebrow">Escritor</p>
    <h1><?= $mode === 'create' ? 'Nueva historia' : 'Editar historia' ?></h1>
</section>

<form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/escribir/libros" class="form auth-card" style="max-width:520px">
    <?= \App\Core\Csrf::field() ?>
    <label>
        Título
        <input type="text" name="title" value="<?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?>" required maxlength="200">
        <?php if (!empty($errors['title'])): ?><span class="field-error"><?= htmlspecialchars($errors['title'], ENT_QUOTES, 'UTF-8') ?></span><?php endif; ?>
    </label>
    <label>
        Género
        <input type="text" name="genre" value="<?= htmlspecialchars((string) ($book['genre'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" maxlength="80">
        <?php if (!empty($errors['genre'])): ?><span class="field-error"><?= htmlspecialchars($errors['genre'], ENT_QUOTES, 'UTF-8') ?></span><?php endif; ?>
    </label>
    <label>
        Sinopsis
        <textarea name="synopsis" rows="5"><?= htmlspecialchars((string) ($book['synopsis'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
        <?php if (!empty($errors['synopsis'])): ?><span class="field-error"><?= htmlspecialchars($errors['synopsis'], ENT_QUOTES, 'UTF-8') ?></span><?php endif; ?>
    </label>
    <label>
        Estado
        <select name="status">
            <?php foreach (['borrador', 'publicado', 'archivado'] as $status): ?>
                <option value="<?= $status ?>" <?= ($book['status'] ?? '') === $status ? 'selected' : '' ?>><?= $status ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['status'])): ?><span class="field-error"><?= htmlspecialchars($errors['status'], ENT_QUOTES, 'UTF-8') ?></span><?php endif; ?>
    </label>
    <button type="submit" class="btn">Crear historia</button>
</form>
