<?php
/** @var string $appUrl */
/** @var string $query */
/** @var list<array> $books */
/** @var list<array> $writers */

$hasQuery = trim($query) !== '';
?>
<section class="discover-hero">
    <div class="discover-hero-copy">
        <p class="eyebrow">Descubrir</p>
        <h1>Explora historias</h1>
        <p class="lead">Busca por título, género o autor y encuentra tu próxima lectura.</p>
    </div>
    <form class="discover-search" method="get" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/descubrir">
        <input
            type="search"
            name="q"
            value="<?= htmlspecialchars($query, ENT_QUOTES, 'UTF-8') ?>"
            placeholder="Buscar por título, género o autor"
            aria-label="Buscar historias o autores"
        >
        <button type="submit" class="btn">Buscar</button>
        <?php if ($hasQuery): ?>
            <a class="btn btn-ghost btn-small" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/descubrir">Limpiar</a>
        <?php endif; ?>
    </form>
    <?php if ($hasQuery): ?>
        <p class="discover-query-hint">Resultados para “<?= htmlspecialchars($query, ENT_QUOTES, 'UTF-8') ?>”</p>
    <?php endif; ?>
</section>

<section class="stack-section home-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Catálogo</p>
            <h2>Historias</h2>
        </div>
    </div>

    <?php if ($books === []): ?>
        <div class="empty-panel">
            <p class="empty-panel-title">No hay resultados de historias</p>
            <p class="empty">
                <?= $hasQuery
                    ? 'Prueba otra búsqueda o limpia el filtro para ver el catálogo completo.'
                    : 'Cuando haya historias publicadas aparecerán aquí.' ?>
            </p>
            <?php if ($hasQuery): ?>
                <a class="btn btn-small" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/descubrir">Ver todas</a>
            <?php else: ?>
                <a class="btn btn-small" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/inicio">Volver al Inicio</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="catalog-list">
            <?php foreach ($books as $book): ?>
                <?php
                $bookId = (int) $book['id'];
                $hue = $bookId * 47 % 360;
                $genre = (string) ($book['genre'] ?? '');
                $synopsis = (string) ($book['synopsis'] ?? '');
                ?>
                <a
                    class="catalog-row"
                    href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/libros/<?= $bookId ?>"
                >
                    <span class="catalog-cover" style="--cover-hue: <?= $hue ?>">
                        <span class="catalog-cover-title"><?= htmlspecialchars(mb_strimwidth($book['title'], 0, 36, '…'), ENT_QUOTES, 'UTF-8') ?></span>
                    </span>
                    <span class="catalog-body">
                        <strong class="catalog-title"><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></strong>
                        <span class="catalog-byline">
                            <?= htmlspecialchars($book['author_name'], ENT_QUOTES, 'UTF-8') ?>
                            <?php if ($genre !== ''): ?>
                                · <em class="genre-chip"><?= htmlspecialchars($genre, ENT_QUOTES, 'UTF-8') ?></em>
                            <?php endif; ?>
                        </span>
                        <?php if ($synopsis !== ''): ?>
                            <span class="catalog-synopsis"><?= htmlspecialchars(mb_strimwidth($synopsis, 0, 180, '…'), ENT_QUOTES, 'UTF-8') ?></span>
                        <?php endif; ?>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<section class="stack-section home-section">
    <?php
    /*
     * Sección Escritores (Comunidad):
     * Sirve para descubrir personas (autores), no solo libros.
     * Al hacer clic se abre el perfil (/u/usuario) para seguirlos o ver sus obras.
     * Completa el flujo tipo Wattpad: catálogo de historias + descubrimiento de autores.
     * Los datos vienen de User::searchWriters (misma búsqueda ?q= que las historias).
     */
    ?>
    <div class="section-heading">
        <div>
            <p class="eyebrow">Comunidad</p>
            <h2>Escritores</h2>
        </div>
    </div>

    <?php if ($writers === []): ?>
        <div class="empty-panel">
            <p class="empty-panel-title">No hay escritores para mostrar</p>
            <p class="empty">
                <?= $hasQuery
                    ? 'Ningún escritor coincide con esa búsqueda.'
                    : 'Cuando haya perfiles de escritor aparecerán aquí.' ?>
            </p>
            <?php if ($hasQuery): ?>
                <a class="btn btn-small" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/descubrir">Limpiar búsqueda</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="writer-chips">
            <?php foreach ($writers as $writer): ?>
                <?php
                $label = (string) ($writer['display_name'] ?? $writer['username'] ?? '?');
                $initial = mb_strtoupper(mb_substr($label, 0, 1));
                ?>
                <a
                    class="writer-chip"
                    href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/u/<?= htmlspecialchars(rawurlencode($writer['username']), ENT_QUOTES, 'UTF-8') ?>"
                >
                    <span class="follow-avatar" aria-hidden="true"><?= htmlspecialchars($initial, ENT_QUOTES, 'UTF-8') ?></span>
                    <span class="follow-text">
                        <strong><?= htmlspecialchars($writer['display_name'], ENT_QUOTES, 'UTF-8') ?></strong>
                        <span>@<?= htmlspecialchars($writer['username'], ENT_QUOTES, 'UTF-8') ?></span>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
