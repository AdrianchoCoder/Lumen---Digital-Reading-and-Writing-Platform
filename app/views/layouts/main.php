<?php
/** @var string $content */
/** @var string $appName */
$appName = $appName ?? 'Lumen';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="assets/css/app.css">
</head>
<body>
    <main class="shell">
        <?= $content ?>
    </main>
</body>
</html>
