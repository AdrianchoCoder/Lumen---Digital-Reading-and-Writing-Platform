<?php
/** @var string $appUrl */
/** @var array $stats */
/** @var list<array> $books */
?>
<section>
    <p class="eyebrow">Escritor</p>
    <h1>Escribir</h1>
    <p class="lead">Gestiona tus historias, comunidades y mira un resumen de tu actividad.</p>
    <p class="actions">
        <a class="btn" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/escribir/libros/nueva">Nueva historia</a>
        <a class="btn btn-ghost" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/escribir/libros">Mis libros</a>
        <a class="btn btn-ghost" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/escribir/comunidades">Comunidades</a>
        <a class="btn btn-ghost" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/escribir/estadisticas">Estadísticas</a>
    </p>
</section>

<section class="stack-section">
    <h2>Resumen rápido</h2>
    <ul class="stat-grid">
        <li><strong><?= (int) $stats['books_total'] ?></strong><span>Historias</span></li>
        <li><strong><?= (int) $stats['books_published'] ?></strong><span>Publicadas</span></li>
        <li><strong><?= (int) $stats['chapters_total'] ?></strong><span>Capítulos</span></li>
        <li><strong><?= (int) $stats['library_saves'] ?></strong><span>En bibliotecas</span></li>
        <li><strong><?= (int) $stats['followers'] ?></strong><span>Seguidores</span></li>
        <li><strong><?= (int) $stats['communities'] ?></strong><span>Comunidades</span></li>
    </ul>
</section>

<section class="stack-section">
    <h2>Tus historias recientes</h2>
    <?php if ($books === []): ?>
        <p class="empty">Aún no has creado historias. <a href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/escribir/libros/nueva">Crea la primera</a>.</p>
    <?php else: ?>
        <ul class="card-list">
            <?php foreach (array_slice($books, 0, 5) as $book): ?>
                <li>
                    <a class="card-link" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/escribir/libros/<?= (int) $book['id'] ?>">
                        <strong><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></strong>
                        <span><?= htmlspecialchars($book['status'], ENT_QUOTES, 'UTF-8') ?> · <?= (int) $book['chapters_count'] ?> capítulos</span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>
