<?php
/** @var string $appUrl */
/** @var array $old */
/** @var array $errors */

use App\Core\AuthRules;

$domainsAttr = implode(',', AuthRules::emailDomains());
$emailHint = AuthRules::emailDomainsHint();
?>
<section class="auth-card">
    <p class="eyebrow">Cuenta</p>
    <h1>Iniciar sesión</h1>
    <p class="lead">Entra con tu correo y contraseña.</p>

    <?php if (!empty($errors['form'])): ?>
        <p class="flash flash-err"><?= htmlspecialchars($errors['form'], ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <form
        method="post"
        action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/login"
        class="form auth-form"
        data-auth-form="login"
        data-email-domains="<?= htmlspecialchars($domainsAttr, ENT_QUOTES, 'UTF-8') ?>"
        novalidate
    >
        <?= \App\Core\Csrf::field() ?>

        <div class="field<?= !empty($errors['email']) ? ' is-invalid' : '' ?>" data-validate="email">
            <label class="field-label" for="login-email">Correo electrónico</label>
            <p class="field-hint">Debe incluir @ y un dominio permitido: <?= htmlspecialchars($emailHint, ENT_QUOTES, 'UTF-8') ?></p>
            <input
                type="email"
                id="login-email"
                name="email"
                value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                required
                autocomplete="email"
                maxlength="190"
                placeholder="ej: nombre@gmail.com"
                aria-describedby="login-email-hint login-email-error"
            >
            <p class="field-hint" id="login-email-hint">Ejemplos válidos: @gmail.com, @hotmail.com, @outlook.com</p>
            <span class="field-error" id="login-email-error" data-error role="alert">
                <?= !empty($errors['email']) ? htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') : '' ?>
            </span>
        </div>

        <div class="field<?= !empty($errors['password']) ? ' is-invalid' : '' ?>" data-validate="password">
            <label class="field-label" for="login-password">Contraseña</label>
            <p class="field-hint">Mínimo 8 caracteres, con mayúscula, minúscula, número y un carácter especial.</p>
            <div class="password-field">
                <input
                    type="password"
                    id="login-password"
                    name="password"
                    required
                    autocomplete="current-password"
                    maxlength="72"
                    placeholder="Tu contraseña"
                    aria-describedby="login-password-hint login-password-error"
                >
                <button type="button" class="password-toggle" data-toggle-password aria-label="Mostrar contraseña" title="Mostrar u ocultar">
                    <svg class="icon-eye" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    <svg class="icon-eye-off" viewBox="0 0 24 24" aria-hidden="true" hidden><path d="M3 3l18 18"/><path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/><path d="M9.9 5.1A10.5 10.5 0 0 1 12 5c6.5 0 10 7 10 7a18 18 0 0 1-4.2 4.8M6.1 6.1A17.6 17.6 0 0 0 2 12s3.5 7 10 7a10.4 10.4 0 0 0 4.2-.9"/></svg>
                </button>
            </div>
            <ul class="field-rules" id="login-password-hint" aria-label="Requisitos de contraseña">
                <li data-rule="length">Al menos 8 caracteres</li>
                <li data-rule="lower">Una minúscula</li>
                <li data-rule="upper">Una mayúscula</li>
                <li data-rule="number">Un número</li>
                <li data-rule="special">Un carácter especial (!@#$…)</li>
            </ul>
            <span class="field-error" id="login-password-error" data-error role="alert">
                <?= !empty($errors['password']) ? htmlspecialchars($errors['password'], ENT_QUOTES, 'UTF-8') : '' ?>
            </span>
        </div>

        <button type="submit" class="btn auth-submit-btn">Entrar</button>
    </form>

    <p class="muted-link">
        ¿No tienes cuenta?
        <a href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/register">Regístrate</a>
    </p>
</section>
