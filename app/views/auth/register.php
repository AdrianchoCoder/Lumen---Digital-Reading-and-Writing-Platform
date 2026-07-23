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
    <h1>Crear cuenta</h1>
    <p class="lead">Te registras como <strong>lector</strong>. Luego podrás solicitar ser escritor.</p>

    <form
        method="post"
        action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/register"
        class="form auth-form"
        data-auth-form="register"
        data-email-domains="<?= htmlspecialchars($domainsAttr, ENT_QUOTES, 'UTF-8') ?>"
        novalidate
    >
        <?= \App\Core\Csrf::field() ?>

        <div class="field<?= !empty($errors['username']) ? ' is-invalid' : '' ?>" data-validate="username">
            <label class="field-label" for="reg-username">Nombre de usuario</label>
            <p class="field-hint">Obligatorio. <?= AuthRules::USERNAME_MIN ?>–<?= AuthRules::USERNAME_MAX ?> caracteres. Debe empezar con letra; luego letras, números o _.</p>
            <input
                type="text"
                id="reg-username"
                name="username"
                value="<?= htmlspecialchars($old['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                required
                autocomplete="username"
                maxlength="<?= AuthRules::USERNAME_MAX ?>"
                placeholder="ej: auroraLee"
                aria-describedby="reg-username-hint reg-username-error"
            >
            <p class="field-hint" id="reg-username-hint">No empieces con número ni símbolo. Sin espacios.</p>
            <span class="field-error" id="reg-username-error" data-error role="alert">
                <?= !empty($errors['username']) ? htmlspecialchars($errors['username'], ENT_QUOTES, 'UTF-8') : '' ?>
            </span>
        </div>

        <div class="field<?= !empty($errors['display_name']) ? ' is-invalid' : '' ?>" data-validate="display_name">
            <label class="field-label" for="reg-display">Nombre visible</label>
            <p class="field-hint">Obligatorio. <?= AuthRules::DISPLAY_NAME_MIN ?>–<?= AuthRules::DISPLAY_NAME_MAX ?> caracteres. Así te verán en Lumen.</p>
            <input
                type="text"
                id="reg-display"
                name="display_name"
                value="<?= htmlspecialchars($old['display_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                required
                autocomplete="name"
                maxlength="<?= AuthRules::DISPLAY_NAME_MAX ?>"
                placeholder="ej: Aurora Lee"
                aria-describedby="reg-display-hint reg-display-error"
            >
            <p class="field-hint" id="reg-display-hint">Debe empezar con una letra. Puedes usar espacios.</p>
            <span class="field-error" id="reg-display-error" data-error role="alert">
                <?= !empty($errors['display_name']) ? htmlspecialchars($errors['display_name'], ENT_QUOTES, 'UTF-8') : '' ?>
            </span>
        </div>

        <div class="field<?= !empty($errors['email']) ? ' is-invalid' : '' ?>" data-validate="email">
            <label class="field-label" for="reg-email">Correo electrónico</label>
            <p class="field-hint">Debe incluir @ y un dominio permitido: <?= htmlspecialchars($emailHint, ENT_QUOTES, 'UTF-8') ?></p>
            <input
                type="email"
                id="reg-email"
                name="email"
                value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                required
                autocomplete="email"
                maxlength="190"
                placeholder="ej: nombre@gmail.com"
                aria-describedby="reg-email-hint reg-email-error"
            >
            <p class="field-hint" id="reg-email-hint">Ejemplos válidos: @gmail.com, @hotmail.com, @outlook.com</p>
            <span class="field-error" id="reg-email-error" data-error role="alert">
                <?= !empty($errors['email']) ? htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') : '' ?>
            </span>
        </div>

        <div class="field<?= !empty($errors['password']) ? ' is-invalid' : '' ?>" data-validate="password">
            <label class="field-label" for="reg-password">Contraseña</label>
            <p class="field-hint">Mínimo 8 caracteres, con mayúscula, minúscula, número y un carácter especial.</p>
            <div class="password-field">
                <input
                    type="password"
                    id="reg-password"
                    name="password"
                    required
                    autocomplete="new-password"
                    maxlength="72"
                    placeholder="Crea una contraseña segura"
                    aria-describedby="reg-password-rules reg-password-error"
                >
                <button type="button" class="password-toggle" data-toggle-password aria-label="Mostrar contraseña" title="Mostrar u ocultar">
                    <svg class="icon-eye" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    <svg class="icon-eye-off" viewBox="0 0 24 24" aria-hidden="true" hidden><path d="M3 3l18 18"/><path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/><path d="M9.9 5.1A10.5 10.5 0 0 1 12 5c6.5 0 10 7 10 7a18 18 0 0 1-4.2 4.8M6.1 6.1A17.6 17.6 0 0 0 2 12s3.5 7 10 7a10.4 10.4 0 0 0 4.2-.9"/></svg>
                </button>
            </div>
            <ul class="field-rules" id="reg-password-rules" aria-label="Requisitos de contraseña">
                <li data-rule="length">Al menos 8 caracteres</li>
                <li data-rule="lower">Una minúscula</li>
                <li data-rule="upper">Una mayúscula</li>
                <li data-rule="number">Un número</li>
                <li data-rule="special">Un carácter especial (!@#$…)</li>
            </ul>
            <span class="field-error" id="reg-password-error" data-error role="alert">
                <?= !empty($errors['password']) ? htmlspecialchars($errors['password'], ENT_QUOTES, 'UTF-8') : '' ?>
            </span>
        </div>

        <div class="field<?= !empty($errors['password_confirm']) ? ' is-invalid' : '' ?>" data-validate="password_confirm">
            <label class="field-label" for="reg-password-confirm">Confirmar contraseña</label>
            <p class="field-hint">Repite la misma contraseña para confirmarla.</p>
            <div class="password-field">
                <input
                    type="password"
                    id="reg-password-confirm"
                    name="password_confirm"
                    required
                    autocomplete="new-password"
                    maxlength="72"
                    placeholder="Repite tu contraseña"
                    aria-describedby="reg-password-confirm-error"
                >
                <button type="button" class="password-toggle" data-toggle-password aria-label="Mostrar confirmación" title="Mostrar u ocultar">
                    <svg class="icon-eye" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    <svg class="icon-eye-off" viewBox="0 0 24 24" aria-hidden="true" hidden><path d="M3 3l18 18"/><path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/><path d="M9.9 5.1A10.5 10.5 0 0 1 12 5c6.5 0 10 7 10 7a18 18 0 0 1-4.2 4.8M6.1 6.1A17.6 17.6 0 0 0 2 12s3.5 7 10 7a10.4 10.4 0 0 0 4.2-.9"/></svg>
                </button>
            </div>
            <span class="field-error" id="reg-password-confirm-error" data-error role="alert">
                <?= !empty($errors['password_confirm']) ? htmlspecialchars($errors['password_confirm'], ENT_QUOTES, 'UTF-8') : '' ?>
            </span>
        </div>

        <button type="submit" class="btn auth-submit-btn">Registrarme</button>
    </form>

    <p class="muted-link">
        ¿Ya tienes cuenta?
        <a href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/login">Inicia sesión</a>
    </p>
</section>
