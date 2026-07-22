<?php
/** @var string $appUrl */
/** @var array $stats */
?>
<section>
    <p class="eyebrow">Administración</p>
    <h1>Panel Admin</h1>
    <p class="lead">Revisa solicitudes de escritor, usuarios y contenido.</p>
</section>

<ul class="stat-grid">
    <li><strong><?= (int) $stats['pending_requests'] ?></strong><span>Solicitudes pendientes</span></li>
    <li><strong><?= (int) $stats['users'] ?></strong><span>Usuarios</span></li>
    <li><strong><?= (int) $stats['books'] ?></strong><span>Historias</span></li>
</ul>

<p class="actions" style="margin-top:1.5rem">
    <a class="btn" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/admin/solicitudes">Solicitudes</a>
    <a class="btn btn-ghost" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/admin/usuarios">Usuarios</a>
    <a class="btn btn-ghost" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/admin/contenido">Contenido</a>
</p>
