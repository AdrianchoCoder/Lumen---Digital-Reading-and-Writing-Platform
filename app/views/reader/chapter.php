<?php
/** @var string $appUrl */
/** @var array $book */
/** @var array $chapter */

$bookUrl = htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') . '/libros/' . (int) $book['id'];
?>
<article class="reader-chapter">
    <header class="reader-chapter-bar">
        <a class="reader-back" href="<?= $bookUrl ?>">← Volver a la historia</a>
        <p class="reader-book-title"><?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?></p>
    </header>

    <div class="reader-chapter-shell">
        <p class="eyebrow">Capítulo <?= (int) $chapter['number'] ?></p>
        <h1 class="reader-chapter-title"><?= htmlspecialchars($chapter['title'], ENT_QUOTES, 'UTF-8') ?></h1>
        <div class="chapter-body reader-chapter-body">
            <?= nl2br(htmlspecialchars($chapter['content'], ENT_QUOTES, 'UTF-8')) ?>
        </div>
    </div>

    <footer class="reader-chapter-foot">
        <a class="btn btn-ghost" href="<?= $bookUrl ?>">Volver a la historia</a>
    </footer>
</article>
