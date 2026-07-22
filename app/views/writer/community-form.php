<?php
/** @var string $appUrl */
/** @var array $community */
/** @var array $errors */
?>
<section>
    <p class="eyebrow">Comunidades</p>
    <h1>Nueva comunidad</h1>
</section>

<form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/escribir/comunidades" class="form auth-card" style="max-width:520px">
    <?= \App\Core\Csrf::field() ?>
    <label>
        Nombre
        <input type="text" name="name" value="<?= htmlspecialchars($community['name'], ENT_QUOTES, 'UTF-8') ?>" required minlength="3" maxlength="120">
        <?php if (!empty($errors['name'])): ?><span class="field-error"><?= htmlspecialchars($errors['name'], ENT_QUOTES, 'UTF-8') ?></span><?php endif; ?>
    </label>
    <label>
        Descripción
        <textarea name="description" rows="5"><?= htmlspecialchars($community['description'], ENT_QUOTES, 'UTF-8') ?></textarea>
        <?php if (!empty($errors['description'])): ?><span class="field-error"><?= htmlspecialchars($errors['description'], ENT_QUOTES, 'UTF-8') ?></span><?php endif; ?>
    </label>
    <button type="submit" class="btn">Crear comunidad</button>
</form>
