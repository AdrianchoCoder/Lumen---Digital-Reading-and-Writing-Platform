<?php
/** @var string $appName */
/** @var string $appUrl */
/** @var list<array> $popularBooks */
?>
<section class="landing-hero">
    <div class="landing-hero-copy">
        <p class="eyebrow">Biblioteca digital</p>
        <h1>Ven por la historia.<br>Quédate por la conexión.</h1>
        <p class="lead">
            Historias que se sienten vivas: lee, guarda tus favoritas y descubre autores
            que escriben para ti. Mejor que el scroll vacío — una comunidad de lectores y escritores.
        </p>
        <p class="actions">
            <a class="btn btn-lg landing-btn" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/register">Comenzar</a>
        </p>
        <p class="landing-hero-login">
            ¿Ya tienes una cuenta?
            <a class="landing-text-link" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/login">Inicia sesión</a>
        </p>
    </div>
    <div class="landing-hero-art" aria-hidden="true">
        <div class="hero-orb"></div>
        <div class="hero-card hero-card-1">
            <span class="hero-avatar">A</span>
            <div>
                <strong>@aurora_lee</strong>
                <p>Este final me dejó sin palabras…</p>
            </div>
        </div>
        <div class="hero-card hero-card-2">
            <span class="hero-avatar">M</span>
            <div>
                <strong>@marco_ink</strong>
                <p>¿Alguien más está leyendo esto a las 2 a.m.?</p>
            </div>
        </div>
    </div>
</section>

<section class="landing-carousel-section" id="populares">
    <div class="carousel-header">
        <div>
            <p class="eyebrow">Para inspirarte</p>
            <h2>Historias populares</h2>
            <p class="lead">Pasa el cursor y elige una. Te invitaremos a unirte para seguir leyendo.</p>
        </div>
        <div class="carousel-controls">
            <button type="button" class="icon-btn landing-interactive" id="carousel-prev" aria-label="Anterior">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 6 9 12l6 6"/></svg>
            </button>
            <button type="button" class="icon-btn landing-interactive" id="carousel-next" aria-label="Siguiente">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m9 6 6 6-6 6"/></svg>
            </button>
        </div>
    </div>

    <?php if ($popularBooks === []): ?>
        <p class="empty">Pronto verás aquí historias de prueba. Mientras tanto, <a href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/register">crea tu cuenta</a>.</p>
    <?php else: ?>
        <div class="book-carousel" id="book-carousel" tabindex="0">
            <?php foreach ($popularBooks as $book): ?>
                <button
                    type="button"
                    class="book-card"
                    data-open-auth-modal
                    data-book-title="<?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?>"
                >
                    <span class="book-cover" style="--cover-hue: <?= (int) ($book['id'] * 47 % 360) ?>">
                        <span class="book-cover-title"><?= htmlspecialchars(mb_strimwidth($book['title'], 0, 42, '…'), ENT_QUOTES, 'UTF-8') ?></span>
                    </span>
                    <span class="book-meta">
                        <strong><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></strong>
                        <span><?= htmlspecialchars($book['author_name'], ENT_QUOTES, 'UTF-8') ?></span>
                        <?php if (!empty($book['genre'])): ?>
                            <em><?= htmlspecialchars($book['genre'], ENT_QUOTES, 'UTF-8') ?></em>
                        <?php endif; ?>
                    </span>
                </button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
