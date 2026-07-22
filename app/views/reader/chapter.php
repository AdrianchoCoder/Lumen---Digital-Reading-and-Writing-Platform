<?php
/** @var string $appUrl */
/** @var array $book */
/** @var array $chapter */
?>
<p><a href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/libros/<?= (int) $book['id'] ?>">← Volver a la historia</a></p>
<section class="chapter-read">
    <p class="eyebrow"><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></p>
    <h1><?= (int) $chapter['number'] ?>. <?= htmlspecialchars($chapter['title'], ENT_QUOTES, 'UTF-8') ?></h1>
    <div class="chapter-body">
        <?= nl2br(htmlspecialchars($chapter['content'], ENT_QUOTES, 'UTF-8')) ?>
    </div>
</section>
