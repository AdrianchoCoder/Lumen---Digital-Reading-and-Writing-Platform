<?php
/** @var string $appName */
/** @var string $dbStatus */
/** @var bool $dbOk */
?>
<section class="hero-check">
    <p class="eyebrow">Núcleo MVC listo</p>
    <h1><?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></h1>
    <p class="lead">
        Estructura base, Router, Controller y conexión PDO configurados.
        El diseño visual completo llegará en el módulo 9.
    </p>
    <p class="db <?= $dbOk ? 'ok' : 'warn' ?>">
        Base de datos: <?= htmlspecialchars($dbStatus, ENT_QUOTES, 'UTF-8') ?>
    </p>
</section>
