<?php
/** @var string $appName */
/** @var string $appUrl */
?>
<section class="hero-check">
    <p class="eyebrow">Biblioteca digital</p>
    <h1><?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></h1>
    <p class="lead">
        Lee, descubre historias y guarda tus favoritas.
        Crea una cuenta de lector para empezar.
    </p>
    <p class="actions">
        <a class="btn" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/register">Crear cuenta</a>
        <a class="btn btn-ghost" href="<?= htmlspecialchars($appUrl, ENT_QUOTES, 'UTF-8') ?>/login">Iniciar sesión</a>
    </p>
</section>
