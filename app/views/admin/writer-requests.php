<?php
/** @var string $appUrl */
/** @var string $filter */
/** @var list<array> $requests */

$filters = [
    'pendiente' => 'Pendientes',
    'aprobado'  => 'Aprobadas',
    'rechazado' => 'Rechazadas',
    'todas'     => 'Todas',
];
?>
<section>
    <p class="eyebrow">Admin</p>
    <h1>Solicitudes de escritor</h1>
    <p class="lead">Aprueba para subir el rol a escritor, o rechaza con una nota opcional.</p>
</section>

<p class="actions">
    <?php foreach ($filters as $key => $label): ?>
        <a class="btn <?= $filter === $key ? '' : 'btn-ghost' ?> btn-small" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/admin/solicitudes?estado=<?= urlencode($key) ?>"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></a>
    <?php endforeach; ?>
</p>

<?php if ($requests === []): ?>
    <p class="empty">No hay solicitudes en este filtro.</p>
<?php else: ?>
    <ul class="card-list">
        <?php foreach ($requests as $item): ?>
            <li class="admin-card">
                <div>
                    <strong><?= htmlspecialchars($item['display_name'], ENT_QUOTES, 'UTF-8') ?></strong>
                    <span class="muted">@<?= htmlspecialchars($item['username'], ENT_QUOTES, 'UTF-8') ?> · <?= htmlspecialchars($item['email'], ENT_QUOTES, 'UTF-8') ?></span>
                    <p><?= nl2br(htmlspecialchars($item['motivation'], ENT_QUOTES, 'UTF-8')) ?></p>
                    <span class="muted">Estado: <?= htmlspecialchars($item['status'], ENT_QUOTES, 'UTF-8') ?> · <?= htmlspecialchars((string) $item['created_at'], ENT_QUOTES, 'UTF-8') ?></span>
                    <?php if (!empty($item['admin_note'])): ?>
                        <p class="muted">Nota: <?= htmlspecialchars($item['admin_note'], ENT_QUOTES, 'UTF-8') ?></p>
                    <?php endif; ?>
                </div>
                <?php if ($item['status'] === 'pendiente'): ?>
                    <div class="admin-actions">
                        <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/admin/solicitudes/<?= (int) $item['id'] ?>/aprobar" class="form">
                            <?= \App\Core\Csrf::field() ?>
                            <label>
                                Nota (opcional)
                                <input type="text" name="admin_note" maxlength="500" placeholder="Bienvenida / comentario">
                            </label>
                            <button type="submit" class="btn btn-small">Aprobar</button>
                        </form>
                        <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/admin/solicitudes/<?= (int) $item['id'] ?>/rechazar" class="form">
                            <?= \App\Core\Csrf::field() ?>
                            <label>
                                Motivo (opcional)
                                <input type="text" name="admin_note" maxlength="500" placeholder="Razones del rechazo">
                            </label>
                            <button type="submit" class="btn btn-ghost btn-small">Rechazar</button>
                        </form>
                    </div>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
