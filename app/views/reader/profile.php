<?php
/** @var string $appUrl */
/** @var array $profile */
/** @var bool $isOwn */
/** @var bool $isFollowing */
/** @var int $followersCount */
/** @var int $followingCount */
/** @var list<array> $authoredBooks */
/** @var array $errors */
/** @var string|null $flashSuccess */

$displayName = (string) ($profile['display_name'] ?? '');
$username = (string) ($profile['username'] ?? '');
$bio = trim((string) ($profile['bio'] ?? ''));
$role = (string) ($profile['role'] ?? '');
$roleLabels = [
    'lector'         => 'Lector',
    'escritor'       => 'Escritor',
    'administrador'  => 'Administrador',
];
$roleLabel = $roleLabels[$role] ?? ucfirst($role);
$initial = mb_strtoupper(mb_substr($displayName !== '' ? $displayName : $username, 0, 1));
$hue = ((int) ($profile['id'] ?? 1)) * 47 % 360;
$showSavedPopup = $isOwn
    && !empty($flashSuccess)
    && str_contains((string) $flashSuccess, 'perfil');
?>
<section class="profile-hero">
    <div class="profile-hero-main">
        <div class="profile-avatar" style="--cover-hue: <?= $hue ?>" aria-hidden="true">
            <?= htmlspecialchars($initial, ENT_QUOTES, 'UTF-8') ?>
        </div>
        <div class="profile-hero-copy">
            <p class="eyebrow"><?= $isOwn ? 'Tu perfil' : 'Perfil' ?></p>
            <h1><?= htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8') ?></h1>
            <p class="profile-handle">
                @<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>
                <em class="genre-chip profile-role"><?= htmlspecialchars($roleLabel, ENT_QUOTES, 'UTF-8') ?></em>
            </p>
            <?php if ($bio !== ''): ?>
                <p class="profile-bio"><?= nl2br(htmlspecialchars($bio, ENT_QUOTES, 'UTF-8')) ?></p>
            <?php elseif ($isOwn): ?>
                <p class="profile-bio profile-bio-empty">Aún no tienes biografía. Cuéntale a la comunidad quién eres.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="profile-stats" aria-label="Estadísticas del perfil">
        <div class="profile-stat">
            <strong><?= (int) $followersCount ?></strong>
            <span>Seguidores</span>
        </div>
        <div class="profile-stat">
            <strong><?= (int) $followingCount ?></strong>
            <span>Siguiendo</span>
        </div>
        <div class="profile-stat">
            <strong><?= count($authoredBooks) ?></strong>
            <span>Historias</span>
        </div>
    </div>

    <?php if (!$isOwn): ?>
        <div class="profile-hero-actions">
            <?php if ($isFollowing): ?>
                <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/dejar-seguir/<?= (int) $profile['id'] ?>">
                    <?= \App\Core\Csrf::field() ?>
                    <button type="submit" class="btn btn-ghost">Dejar de seguir</button>
                </form>
            <?php else: ?>
                <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/seguir/<?= (int) $profile['id'] ?>">
                    <?= \App\Core\Csrf::field() ?>
                    <button type="submit" class="btn">Seguir</button>
                </form>
            <?php endif; ?>
            <a class="btn btn-ghost" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/descubrir">Volver a Descubrir</a>
        </div>
    <?php endif; ?>
</section>

<?php if ($isOwn): ?>
    <section class="stack-section home-section">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Cuenta</p>
                <h2>Editar perfil</h2>
            </div>
        </div>
        <div class="profile-edit">
            <form method="post" action="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/perfil" class="form profile-form">
                <?= \App\Core\Csrf::field() ?>
                <label>
                    Nombre visible
                    <input
                        type="text"
                        name="display_name"
                        value="<?= htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8') ?>"
                        maxlength="100"
                        required
                        autocomplete="nickname"
                    >
                    <?php if (!empty($errors['display_name'])): ?>
                        <span class="field-error"><?= htmlspecialchars($errors['display_name'], ENT_QUOTES, 'UTF-8') ?></span>
                    <?php endif; ?>
                </label>
                <label>
                    Biografía
                    <textarea name="bio" rows="4" maxlength="500" placeholder="Una frase sobre ti, tus gustos o lo que escribes…"><?= htmlspecialchars((string) ($profile['bio'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
                    <?php if (!empty($errors['bio'])): ?>
                        <span class="field-error"><?= htmlspecialchars($errors['bio'], ENT_QUOTES, 'UTF-8') ?></span>
                    <?php endif; ?>
                </label>
                <div class="profile-form-actions">
                    <button type="submit" class="btn">Guardar cambios</button>
                </div>
            </form>
        </div>
    </section>
<?php endif; ?>

<section class="stack-section home-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Obras</p>
            <h2><?= $isOwn ? 'Tus historias publicadas' : 'Historias publicadas' ?></h2>
        </div>
    </div>

    <?php if ($authoredBooks === []): ?>
        <div class="empty-panel">
            <p class="empty-panel-title"><?= $isOwn ? 'Todavía no tienes historias publicadas' : 'Sin historias publicadas' ?></p>
            <p class="empty">
                <?= $isOwn
                    ? 'Cuando publiques desde Escribir, aparecerán aquí en tu perfil.'
                    : 'Este usuario aún no ha publicado obras.' ?>
            </p>
            <?php if ($isOwn && in_array($role, ['escritor', 'administrador'], true)): ?>
                <a class="btn btn-small" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/escribir">Ir a Escribir</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="book-grid">
            <?php foreach ($authoredBooks as $book): ?>
                <?php
                $bookId = (int) $book['id'];
                $bookHue = $bookId * 47 % 360;
                $genre = (string) ($book['genre'] ?? '');
                ?>
                <a
                    class="story-card"
                    href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/libros/<?= $bookId ?>"
                >
                    <span class="story-cover" style="--cover-hue: <?= $bookHue ?>">
                        <span class="story-cover-title"><?= htmlspecialchars(mb_strimwidth($book['title'], 0, 48, '…'), ENT_QUOTES, 'UTF-8') ?></span>
                    </span>
                    <span class="story-meta">
                        <strong><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></strong>
                        <?php if ($genre !== ''): ?>
                            <em class="genre-chip"><?= htmlspecialchars($genre, ENT_QUOTES, 'UTF-8') ?></em>
                        <?php endif; ?>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php if ($showSavedPopup): ?>
    <div
        class="app-popup"
        id="profile-saved-popup"
        role="dialog"
        aria-modal="true"
        aria-labelledby="profile-saved-title"
    >
        <div class="app-popup-backdrop" data-close-popup></div>
        <div class="app-popup-card">
            <div class="app-popup-icon" aria-hidden="true">✓</div>
            <h2 id="profile-saved-title">Perfil actualizado</h2>
            <p><?= htmlspecialchars((string) $flashSuccess, ENT_QUOTES, 'UTF-8') ?></p>
            <button type="button" class="btn" data-close-popup>Entendido</button>
        </div>
    </div>
    <script>
        (function () {
            var popup = document.getElementById('profile-saved-popup');
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
