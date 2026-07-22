<?php
/** @var string $appUrl */
/** @var array $old */
/** @var array $errors */
?>
<section class="auth-card">
    <p class="eyebrow">Cuenta</p>
    <h1>Iniciar sesión</h1>
    <p class="lead">Entra con tu correo y contraseña.</p>

    <?php if (!empty($errors['form'])): ?>
        <p class="flash flash-err"><?= htmlspecialchars($errors['form'], ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/login" class="form" novalidate>
        <?= \App\Core\Csrf::field() ?>

        <label>
            Correo
            <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required autocomplete="email">
            <?php if (!empty($errors['email'])): ?>
                <span class="field-error"><?= htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') ?></span>
            <?php endif; ?>
        </label>

        <label>
            Contraseña
            <input type="password" name="password" required autocomplete="current-password">
            <?php if (!empty($errors['password'])): ?>
                <span class="field-error"><?= htmlspecialchars($errors['password'], ENT_QUOTES, 'UTF-8') ?></span>
            <?php endif; ?>
        </label>

        <button type="submit" class="btn">Entrar</button>
    </form>

    <p class="muted-link">
        ¿No tienes cuenta?
        <a href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/register">Regístrate</a>
    </p>
</section>
