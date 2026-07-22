<?php
/** @var string $appUrl */
/** @var array $old */
/** @var array $errors */
?>
<section class="auth-card">
    <p class="eyebrow">Cuenta</p>
    <h1>Crear cuenta</h1>
    <p class="lead">Te registras como <strong>lector</strong>. Luego podrás solicitar ser escritor.</p>

    <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/register" class="form" novalidate>
        <?= \App\Core\Csrf::field() ?>

        <label>
            Nombre de usuario
            <input type="text" name="username" value="<?= htmlspecialchars($old['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required autocomplete="username">
            <?php if (!empty($errors['username'])): ?>
                <span class="field-error"><?= htmlspecialchars($errors['username'], ENT_QUOTES, 'UTF-8') ?></span>
            <?php endif; ?>
        </label>

        <label>
            Nombre visible
            <input type="text" name="display_name" value="<?= htmlspecialchars($old['display_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required autocomplete="name">
            <?php if (!empty($errors['display_name'])): ?>
                <span class="field-error"><?= htmlspecialchars($errors['display_name'], ENT_QUOTES, 'UTF-8') ?></span>
            <?php endif; ?>
        </label>

        <label>
            Correo
            <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required autocomplete="email">
            <?php if (!empty($errors['email'])): ?>
                <span class="field-error"><?= htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') ?></span>
            <?php endif; ?>
        </label>

        <label>
            Contraseña
            <input type="password" name="password" required autocomplete="new-password">
            <?php if (!empty($errors['password'])): ?>
                <span class="field-error"><?= htmlspecialchars($errors['password'], ENT_QUOTES, 'UTF-8') ?></span>
            <?php endif; ?>
        </label>

        <label>
            Confirmar contraseña
            <input type="password" name="password_confirm" required autocomplete="new-password">
            <?php if (!empty($errors['password_confirm'])): ?>
                <span class="field-error"><?= htmlspecialchars($errors['password_confirm'], ENT_QUOTES, 'UTF-8') ?></span>
            <?php endif; ?>
        </label>

        <button type="submit" class="btn">Registrarme</button>
    </form>

    <p class="muted-link">
        ¿Ya tienes cuenta?
        <a href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/login">Inicia sesión</a>
    </p>
</section>
