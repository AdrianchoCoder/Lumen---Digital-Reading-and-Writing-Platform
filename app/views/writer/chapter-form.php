<?php
/** @var string $appUrl */
/** @var string $mode */
/** @var array $book */
/** @var array $chapter */
/** @var array $errors */
$action = $mode === 'create'
    ? $appUrl . '/escribir/libros/' . (int) $book['id'] . '/capitulos'
    : $appUrl . '/escribir/libros/' . (int) $book['id'] . '/capitulos/' . (int) $chapter['id'];
?>
<section>
    <p class="eyebrow"><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></p>
    <h1><?= $mode === 'create' ? 'Nuevo capítulo' : 'Editar capítulo' ?></h1>
    <?php if (!empty($chapter['number'])): ?>
        <p class="lead">Número: <?= (int) $chapter['number'] ?></p>
    <?php endif; ?>
</section>

<form method="post" action="<?= htmlspecialchars($action, ENT_QUOTES, 'UTF-8') ?>" class="form auth-card" style="max-width:640px">
    <?= \App\Core\Csrf::field() ?>
    <label>
        Título del capítulo
        <input type="text" name="title" value="<?= htmlspecialchars($chapter['title'], ENT_QUOTES, 'UTF-8') ?>" required maxlength="200">
        <?php if (!empty($errors['title'])): ?><span class="field-error"><?= htmlspecialchars($errors['title'], ENT_QUOTES, 'UTF-8') ?></span><?php endif; ?>
    </label>
    <label>
        Contenido
        <textarea name="content" rows="14" required><?= htmlspecialchars($chapter['content'], ENT_QUOTES, 'UTF-8') ?></textarea>
        <?php if (!empty($errors['content'])): ?><span class="field-error"><?= htmlspecialchars($errors['content'], ENT_QUOTES, 'UTF-8') ?></span><?php endif; ?>
    </label>
    <label>
        Estado
        <select name="status">
            <?php foreach (['borrador', 'publicado'] as $status): ?>
                <option value="<?= $status ?>" <?= ($chapter['status'] ?? '') === $status ? 'selected' : '' ?>><?= $status ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <button type="submit" class="btn"><?= $mode === 'create' ? 'Crear capítulo' : 'Guardar capítulo' ?></button>
</form>
