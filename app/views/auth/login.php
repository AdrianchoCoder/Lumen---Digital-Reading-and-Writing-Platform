<?php
/** @var string $appUrl */
/** @var array $old */
/** @var array $errors */

use App\Core\AuthRules;

$domainsAttr = implode(',', AuthRules::emailDomains());
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
        class="form auth-form auth-form-compact"
        data-auth-form="login"
        data-email-domains="<?= htmlspecialchars($domainsAttr, ENT_QUOTES, 'UTF-8') ?>"
        novalidate
    >
        <?= \App\Core\Csrf::field() ?>

        <div class="field<?= !empty($errors['email']) ? ' is-invalid' : '' ?>" data-validate="email">
            <label class="field-label" for="login-email">Correo</label>
            <input
                type="email"
                id="login-email"
                name="email"
                value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                required
                autocomplete="email"
                maxlength="190"
                placeholder="nombre@gmail.com"
                aria-describedby="login-email-error"
            >
            <span class="field-error" id="login-email-error" data-error role="alert"><?= !empty($errors['email']) ? htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') : '' ?></span>
        </div>

        <div class="field<?= !empty($errors['password']) ? ' is-invalid' : '' ?>" data-validate="password">
            <label class="field-label" for="login-password">Contraseña</label>
            <div class="password-field">
                <input
                    type="password"
                    id="login-password"
                    name="password"
                    required
                    autocomplete="current-password"
                    maxlength="72"
                    placeholder="••••••••"
                    aria-describedby="login-password-strength login-password-error"
                >
                <button type="button" class="password-toggle" data-toggle-password aria-label="Mostrar contraseña" title="Mostrar contraseña">
                    <svg class="icon-eye" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    <svg class="icon-eye-off" viewBox="0 0 24 24" aria-hidden="true" hidden>
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-6.5 0-10-8-10-8a18.45 18.45 0 0 1 5.06-5.94"/>
                        <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c6.5 0 10 8 10 8a18.5 18.5 0 0 1-2.16 3.19"/>
                        <path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"/>
                        <line x1="1" y1="1" x2="23" y2="23"/>
                    </svg>
                </button>
            </div>
            <p class="password-strength" id="login-password-strength" data-password-strength aria-label="Requisitos">
                <span data-rule="length">8+</span>
                <span data-rule="lower">a-z</span>
                <span data-rule="upper">A-Z</span>
                <span data-rule="number">0-9</span>
                <span data-rule="special">símbolo</span>
            </p>
            <span class="field-error" id="login-password-error" data-error role="alert"><?= !empty($errors['password']) ? htmlspecialchars($errors['password'], ENT_QUOTES, 'UTF-8') : '' ?></span>
        </div>

        <button type="submit" class="btn auth-submit-btn">Entrar</button>
    </form>

    <p class="muted-link">
        ¿No tienes cuenta?
        <a href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/register">Regístrate</a>
    </p>
</section>
