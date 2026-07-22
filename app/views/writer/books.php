<?php
/** @var string $appUrl */
/** @var list<array> $books */
?>
<section>
    <p class="eyebrow">Escritor</p>
    <h1>Mis libros</h1>
    <p class="actions">
        <a class="btn" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/escribir/libros/nueva">Nueva historia</a>
    </p>
</section>

<?php if ($books === []): ?>
    <p class="empty">No tienes historias todavía.</p>
<?php else: ?>
    <ul class="card-list">
        <?php foreach ($books as $book): ?>
            <li>
                <a class="card-link" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/escribir/libros/<?= (int) $book['id'] ?>">
                    <strong><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></strong>
                    <span>
                        <?= htmlspecialchars($book['status'], ENT_QUOTES, 'UTF-8') ?>
                        · <?= htmlspecialchars((string) ($book['genre'] ?? 'Sin género'), ENT_QUOTES, 'UTF-8') ?>
                        · <?= (int) $book['chapters_count'] ?> capítulos
                    </span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
