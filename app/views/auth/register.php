<?php
/** @var string $appUrl */
/** @var array $old */
/** @var array $errors */

use App\Core\AuthRules;

$domainsAttr = implode(',', AuthRules::emailDomains());
?>
<section class="auth-card">
    <p class="eyebrow">Cuenta</p>
    <h1>Crear cuenta</h1>
    <p class="lead">Te registras como <strong>lector</strong>.</p>

    <form
        method="post"
        action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/register"
        class="form auth-form auth-form-compact"
        data-auth-form="register"
        data-email-domains="<?= htmlspecialchars($domainsAttr, ENT_QUOTES, 'UTF-8') ?>"
        novalidate
    >
        <?= \App\Core\Csrf::field() ?>

        <div class="auth-fields-row">
            <div class="field<?= !empty($errors['username']) ? ' is-invalid' : '' ?>" data-validate="username">
                <label class="field-label" for="reg-username">Usuario</label>
                <input
                    type="text"
                    id="reg-username"
                    name="username"
                    value="<?= htmlspecialchars($old['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    required
                    autocomplete="username"
                    maxlength="<?= AuthRules::USERNAME_MAX ?>"
                    placeholder="auroraLee"
                    aria-describedby="reg-username-error"
                >
                <span class="field-error" id="reg-username-error" data-error role="alert"><?= !empty($errors['username']) ? htmlspecialchars($errors['username'], ENT_QUOTES, 'UTF-8') : '' ?></span>
            </div>

            <div class="field<?= !empty($errors['display_name']) ? ' is-invalid' : '' ?>" data-validate="display_name">
                <label class="field-label" for="reg-display">Nombre visible</label>
                <input
                    type="text"
                    id="reg-display"
                    name="display_name"
                    value="<?= htmlspecialchars($old['display_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    required
                    autocomplete="name"
                    maxlength="<?= AuthRules::DISPLAY_NAME_MAX ?>"
                    placeholder="Aurora Lee"
                    aria-describedby="reg-display-error"
                >
                <span class="field-error" id="reg-display-error" data-error role="alert"><?= !empty($errors['display_name']) ? htmlspecialchars($errors['display_name'], ENT_QUOTES, 'UTF-8') : '' ?></span>
            </div>
        </div>

        <div class="field<?= !empty($errors['email']) ? ' is-invalid' : '' ?>" data-validate="email">
            <label class="field-label" for="reg-email">Correo</label>
            <input
                type="email"
                id="reg-email"
                name="email"
                value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                required
                autocomplete="email"
                maxlength="190"
                placeholder="nombre@gmail.com"
                aria-describedby="reg-email-error"
            >
            <span class="field-error" id="reg-email-error" data-error role="alert"><?= !empty($errors['email']) ? htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') : '' ?></span>
        </div>

        <div class="field<?= !empty($errors['password']) ? ' is-invalid' : '' ?>" data-validate="password">
            <label class="field-label" for="reg-password">Contraseña</label>
            <div class="password-field">
                <input
                    type="password"
                    id="reg-password"
                    name="password"
                    required
                    autocomplete="new-password"
                    maxlength="72"
                    placeholder="••••••••"
                    aria-describedby="reg-password-strength reg-password-error"
                >
                <button type="button" class="password-toggle" data-toggle-password aria-label="Mostrar contraseña" title="Mostrar contraseña">
                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                </button>
            </div>
            <p class="password-strength" id="reg-password-strength" data-password-strength aria-label="Requisitos">
                <span data-rule="length">8+</span>
                <span data-rule="lower">a-z</span>
                <span data-rule="upper">A-Z</span>
                <span data-rule="number">0-9</span>
                <span data-rule="special">símbolo</span>
            </p>
            <span class="field-error" id="reg-password-error" data-error role="alert"><?= !empty($errors['password']) ? htmlspecialchars($errors['password'], ENT_QUOTES, 'UTF-8') : '' ?></span>
        </div>

        <div class="field<?= !empty($errors['password_confirm']) ? ' is-invalid' : '' ?>" data-validate="password_confirm">
            <label class="field-label" for="reg-password-confirm">Confirmar</label>
            <div class="password-field">
                <input
                    type="password"
                    id="reg-password-confirm"
                    name="password_confirm"
                    required
                    autocomplete="new-password"
                    maxlength="72"
                    placeholder="Repite la contraseña"
                    aria-describedby="reg-password-confirm-error"
                >
                <button type="button" class="password-toggle" data-toggle-password aria-label="Mostrar confirmación" title="Mostrar contraseña">
                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                </button>
            </div>
            <span class="field-error" id="reg-password-confirm-error" data-error role="alert"><?= !empty($errors['password_confirm']) ? htmlspecialchars($errors['password_confirm'], ENT_QUOTES, 'UTF-8') : '' ?></span>
        </div>

        <button type="submit" class="btn auth-submit-btn">Registrarme</button>
    </form>

    <p class="muted-link">
        ¿Ya tienes cuenta?
        <a href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/login">Inicia sesión</a>
    </p>
</section>
