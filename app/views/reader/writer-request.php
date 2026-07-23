<?php
/** @var string $appUrl */
/** @var string $role */
/** @var array|null $latest */
/** @var list<array> $history */
/** @var bool $canSubmit */
/** @var string $motivationOld */
/** @var array $errors */
/** @var string|null $flashSuccess */

$statusLabels = [
    'pendiente' => 'Pendiente de revisión',
    'aprobado'  => 'Aprobada',
    'rechazado' => 'Rechazada',
];

$statusTone = [
    'pendiente' => 'is-pending',
    'aprobado'  => 'is-ok',
    'rechazado' => 'is-bad',
];

$showThanksPopup = !empty($flashSuccess) && str_contains((string) $flashSuccess, 'solicitud');
$roleLabels = [
    'lector'         => 'Lector',
    'escritor'       => 'Escritor',
    'administrador'  => 'Administrador',
];
$roleLabel = $roleLabels[$role] ?? ucfirst($role);
?>
<section class="writer-request-hero">
    <div class="writer-request-hero-copy">
        <p class="eyebrow">Crecer en Lumen</p>
        <h1>Conviértete en escritor</h1>
        <p class="lead">
            Comparte tus historias con la comunidad. Cuéntanos por qué quieres publicar
            y un administrador revisará tu solicitud.
        </p>
        <ul class="writer-request-perks">
            <li>Publica historias y capítulos</li>
            <li>Aparece en Descubrir para nuevos lectores</li>
            <li>Construye tu perfil de autor</li>
        </ul>
    </div>
    <div class="writer-request-badge" aria-hidden="true">
        <span class="writer-request-badge-mark">✎</span>
        <span class="writer-request-badge-label">Ser escritor</span>
    </div>
</section>

<?php if ($role !== 'lector'): ?>
    <div class="writer-request-status is-ok">
        <p class="writer-request-status-title">Ya formas parte del equipo creativo</p>
        <p>Tu cuenta es <strong><?= htmlspecialchars($roleLabel, ENT_QUOTES, 'UTF-8') ?></strong>. No necesitas enviar esta solicitud.</p>
        <?php if (in_array($role, ['escritor', 'administrador'], true)): ?>
            <a class="btn btn-small" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/escribir">Ir a Escribir</a>
        <?php endif; ?>
    </div>
<?php elseif ($latest !== null && $latest['status'] === 'pendiente'): ?>
    <div class="writer-request-status is-pending">
        <p class="writer-request-status-title">Solicitud en revisión</p>
        <p>
            Enviada el <?= htmlspecialchars((string) $latest['created_at'], ENT_QUOTES, 'UTF-8') ?>.
            Pronto un administrador te responderá.
        </p>
        <div class="writer-request-motivation">
            <h2>Tu motivación</h2>
            <p><?= nl2br(htmlspecialchars($latest['motivation'], ENT_QUOTES, 'UTF-8')) ?></p>
        </div>
    </div>
<?php elseif ($latest !== null && $latest['status'] === 'rechazado'): ?>
    <div class="writer-request-status is-bad">
        <p class="writer-request-status-title">Solicitud rechazada</p>
        <p>Puedes enviar una nueva solicitud reforzando tu motivación.</p>
        <?php if (!empty($latest['admin_note'])): ?>
            <p class="writer-request-note">
                <strong>Nota del admin:</strong>
                <?= htmlspecialchars($latest['admin_note'], ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>
    </div>
<?php elseif ($latest !== null && $latest['status'] === 'aprobado'): ?>
    <div class="writer-request-status is-ok">
        <p class="writer-request-status-title">¡Solicitud aprobada!</p>
        <p>Cierra sesión y vuelve a entrar para ver el menú de escritor (el rol se actualiza al iniciar sesión).</p>
        <a class="btn btn-small" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/escribir">Ir a Escribir</a>
    </div>
<?php endif; ?>

<?php if ($canSubmit): ?>
    <section class="stack-section home-section">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Tu historia empieza aquí</p>
                <h2>Envía tu solicitud</h2>
            </div>
        </div>
        <div class="writer-request-form-card">
            <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/solicitar-escritor" class="form writer-request-form">
                <?= \App\Core\Csrf::field() ?>
                <label>
                    ¿Por qué quieres publicar en Lumen?
                    <textarea
                        name="motivation"
                        rows="7"
                        required
                        minlength="30"
                        maxlength="2000"
                        placeholder="Habla de los géneros que escribes, tu experiencia o qué historias te gustaría compartir…"
                    ><?= htmlspecialchars($motivationOld, ENT_QUOTES, 'UTF-8') ?></textarea>
                    <?php if (!empty($errors['motivation'])): ?>
                        <span class="field-error"><?= htmlspecialchars($errors['motivation'], ENT_QUOTES, 'UTF-8') ?></span>
                    <?php else: ?>
                        <span class="field-hint">Mínimo 30 caracteres. Sé claro y auténtico.</span>
                    <?php endif; ?>
                </label>
                <div class="writer-request-form-actions">
                    <button type="submit" class="btn">Enviar solicitud</button>
                </div>
            </form>
        </div>
    </section>
<?php endif; ?>

<?php if ($history !== []): ?>
    <section class="stack-section home-section">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Seguimiento</p>
                <h2>Historial de solicitudes</h2>
            </div>
        </div>
        <ul class="writer-request-history">
            <?php foreach ($history as $item): ?>
                <?php $tone = $statusTone[$item['status']] ?? ''; ?>
                <li class="writer-request-history-item <?= htmlspecialchars($tone, ENT_QUOTES, 'UTF-8') ?>">
                    <div class="writer-request-history-head">
                        <strong><?= htmlspecialchars($statusLabels[$item['status']] ?? $item['status'], ENT_QUOTES, 'UTF-8') ?></strong>
                        <span><?= htmlspecialchars((string) $item['created_at'], ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                    <p><?= htmlspecialchars(mb_strimwidth($item['motivation'], 0, 140, '…'), ENT_QUOTES, 'UTF-8') ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
<?php endif; ?>

<?php if ($showThanksPopup): ?>
    <div
        class="app-popup"
        id="writer-request-popup"
        role="dialog"
        aria-modal="true"
        aria-labelledby="writer-request-popup-title"
    >
        <div class="app-popup-backdrop" data-close-popup></div>
        <div class="app-popup-card">
            <div class="app-popup-icon" aria-hidden="true">✦</div>
            <h2 id="writer-request-popup-title">¡Solicitud enviada!</h2>
            <p><?= htmlspecialchars((string) $flashSuccess, ENT_QUOTES, 'UTF-8') ?></p>
            <button type="button" class="btn" data-close-popup>Entendido</button>
        </div>
    </div>
    <script>
        (function () {
            var popup = document.getElementById('writer-request-popup');
            if (!popup) return;
            document.body.classList.add('modal-open');
            function closePopup() {
                popup.hidden = true;
                document.body.classList.remove('modal-open');
            }
            popup.querySelectorAll('[data-close-popup]').forEach(function (el) {
                el.addEventListener('click', closePopup);
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closePopup();
            });
        })();
    </script>
<?php endif; ?>
