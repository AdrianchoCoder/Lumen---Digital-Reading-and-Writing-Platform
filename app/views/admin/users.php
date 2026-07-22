<?php
/** @var string $appUrl */
/** @var string $query */
/** @var list<array> $users */
/** @var int $adminId */
/** @var list<string> $roles */
?>
<section>
    <p class="eyebrow">Admin</p>
    <h1>Usuarios</h1>
    <form class="search-form" method="get" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/admin/usuarios">
        <input type="search" name="q" value="<?= htmlspecialchars($query, ENT_QUOTES, 'UTF-8') ?>" placeholder="Buscar usuario, correo o nombre">
        <button type="submit" class="btn">Buscar</button>
    </form>
</section>

<?php if ($users === []): ?>
    <p class="empty">No hay usuarios para mostrar.</p>
<?php else: ?>
    <ul class="card-list">
        <?php foreach ($users as $user): ?>
            <li class="admin-card">
                <div>
                    <strong><?= htmlspecialchars($user['display_name'], ENT_QUOTES, 'UTF-8') ?></strong>
                    <span class="muted">
                        @<?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?>
                        · <?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?>
                        · <?= htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8') ?>
                        · <?= (int) $user['is_active'] === 1 ? 'activo' : 'inactivo' ?>
                    </span>
                </div>
                <?php if ((int) $user['id'] !== $adminId): ?>
                    <div class="admin-actions">
                        <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/admin/usuarios/<?= (int) $user['id'] ?>/rol" class="inline-tools">
                            <?= \App\Core\Csrf::field() ?>
                            <select name="role">
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= htmlspecialchars($role, ENT_QUOTES, 'UTF-8') ?>" <?= $user['role'] === $role ? 'selected' : '' ?>><?= htmlspecialchars($role, ENT_QUOTES, 'UTF-8') ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn btn-small">Cambiar rol</button>
                        </form>
                        <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/admin/usuarios/<?= (int) $user['id'] ?>/toggle">
                            <?= \App\Core\Csrf::field() ?>
                            <button type="submit" class="btn btn-ghost btn-small">
                                <?= (int) $user['is_active'] === 1 ? 'Desactivar' : 'Activar' ?>
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <span class="muted">Tu cuenta</span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
