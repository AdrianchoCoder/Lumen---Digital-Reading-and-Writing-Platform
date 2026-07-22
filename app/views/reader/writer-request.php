<?php
/** @var string $appUrl */
/** @var string $role */
/** @var array|null $latest */
/** @var list<array> $history */
/** @var bool $canSubmit */
/** @var string $motivationOld */
/** @var array $errors */

$statusLabels = [
    'pendiente' => 'Pendiente de revisión',
    'aprobado'  => 'Aprobada',
    'rechazado' => 'Rechazada',
];
?>
<section>
    <p class="eyebrow">Crecer en Lumen</p>
    <h1>Solicitar ser escritor</h1>
    <p class="lead">
        Los lectores pueden pedir permiso para publicar historias.
        Un administrador revisará tu motivación (módulo Admin).
    </p>
</section>

<?php if ($role !== 'lector'): ?>
    <p class="flash flash-ok">
        Tu cuenta ya es <strong><?= htmlspecialchars($role, ENT_QUOTES, 'UTF-8') ?></strong>.
        No necesitas enviar esta solicitud.
    </p>
<?php elseif ($latest !== null && $latest['status'] === 'pendiente'): ?>
    <p class="flash flash-ok">
        Ya tienes una solicitud <strong>pendiente</strong> desde
        <?= htmlspecialchars((string) $latest['created_at'], ENT_QUOTES, 'UTF-8') ?>.
        Espera la respuesta del administrador.
    </p>
    <div class="request-box">
        <h2>Tu motivación enviada</h2>
        <p><?= nl2br(htmlspecialchars($latest['motivation'], ENT_QUOTES, 'UTF-8')) ?></p>
    </div>
<?php elseif ($latest !== null && $latest['status'] === 'rechazado'): ?>
    <p class="flash flash-err">
        Tu última solicitud fue <strong>rechazada</strong>.
        <?php if (!empty($latest['admin_note'])): ?>
            Nota del admin: <?= htmlspecialchars($latest['admin_note'], ENT_QUOTES, 'UTF-8') ?>
        <?php endif; ?>
        Puedes enviar una nueva solicitud mejorando tu motivación.
    </p>
<?php elseif ($latest !== null && $latest['status'] === 'aprobado'): ?>
    <p class="flash flash-ok">
        Tu solicitud fue aprobada. Cierra sesión y vuelve a entrar para ver el menú de escritor
        (la sesión guarda el rol al iniciar sesión).
    </p>
<?php endif; ?>

<?php if ($canSubmit): ?>
    <section class="stack-section auth-card">
        <h2>Formulario</h2>
        <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/solicitar-escritor" class="form">
            <?= \App\Core\Csrf::field() ?>
            <label>
                ¿Por qué quieres publicar en Lumen?
                <textarea name="motivation" rows="6" required minlength="30" maxlength="2000" placeholder="Habla de los géneros que escribes, tu experiencia o qué historias te gustaría compartir..."><?= htmlspecialchars($motivationOld, ENT_QUOTES, 'UTF-8') ?></textarea>
                <?php if (!empty($errors['motivation'])): ?>
                    <span class="field-error"><?= htmlspecialchars($errors['motivation'], ENT_QUOTES, 'UTF-8') ?></span>
                <?php endif; ?>
            </label>
            <button type="submit" class="btn">Enviar solicitud</button>
        </form>
    </section>
<?php endif; ?>

<?php if ($history !== []): ?>
    <section class="stack-section">
        <h2>Historial</h2>
        <ul class="card-list">
            <?php foreach ($history as $item): ?>
                <li class="card-link">
                    <strong><?= htmlspecialchars($statusLabels[$item['status']] ?? $item['status'], ENT_QUOTES, 'UTF-8') ?></strong>
                    <span><?= htmlspecialchars((string) $item['created_at'], ENT_QUOTES, 'UTF-8') ?></span>
                    <em><?= htmlspecialchars(mb_strimwidth($item['motivation'], 0, 120, '…'), ENT_QUOTES, 'UTF-8') ?></em>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
<?php endif; ?>
