<?php
/** @var array $stats */
?>
<section>
    <p class="eyebrow">Escritor</p>
    <h1>Estadísticas</h1>
    <p class="lead">Números simples de tu actividad en Lumen (sin gráficos aún).</p>
</section>

<ul class="stat-grid">
    <li><strong><?= (int) $stats['books_total'] ?></strong><span>Historias totales</span></li>
    <li><strong><?= (int) $stats['books_published'] ?></strong><span>Publicadas</span></li>
    <li><strong><?= (int) $stats['books_draft'] ?></strong><span>Borradores</span></li>
    <li><strong><?= (int) $stats['chapters_total'] ?></strong><span>Capítulos</span></li>
    <li><strong><?= (int) $stats['library_saves'] ?></strong><span>Guardados en bibliotecas</span></li>
    <li><strong><?= (int) $stats['followers'] ?></strong><span>Seguidores</span></li>
    <li><strong><?= (int) $stats['following'] ?></strong><span>Siguiendo</span></li>
    <li><strong><?= (int) $stats['communities'] ?></strong><span>Comunidades</span></li>
</ul>
