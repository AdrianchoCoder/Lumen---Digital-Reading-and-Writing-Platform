<?php
/** @var string $appUrl */
/** @var list<array> $communities */
?>
<section>
    <p class="eyebrow">Escritor</p>
    <h1>Comunidades</h1>
    <p class="lead">Crea espacios temáticos alrededor de tu escritura (versión básica).</p>
    <p class="actions">
        <a class="btn" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/escribir/comunidades/nueva">Nueva comunidad</a>
    </p>
</section>

<?php if ($communities === []): ?>
    <p class="empty">Aún no tienes comunidades.</p>
<?php else: ?>
    <ul class="card-list">
        <?php foreach ($communities as $community): ?>
            <li class="card-row">
                <div class="card-link">
                    <strong><?= htmlspecialchars($community['name'], ENT_QUOTES, 'UTF-8') ?></strong>
                    <span><?= (int) $community['is_active'] === 1 ? 'Activa' : 'Inactiva' ?></span>
                    <?php if (!empty($community['description'])): ?>
                        <em><?= htmlspecialchars(mb_strimwidth($community['description'], 0, 140, '…'), ENT_QUOTES, 'UTF-8') ?></em>
                    <?php endif; ?>
                </div>
                <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/escribir/comunidades/<?= (int) $community['id'] ?>/toggle">
                    <?= \App\Core\Csrf::field() ?>
                    <button type="submit" class="btn btn-ghost btn-small">
                        <?= (int) $community['is_active'] === 1 ? 'Desactivar' : 'Activar' ?>
                    </button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
