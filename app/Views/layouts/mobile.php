<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#f6f8f7">
    <title><?= esc($title) ?></title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link
        href="<?= base_url('assets/css/lafinance.css') ?>"
        rel="stylesheet">
</head>

<body>
    <main class="app-shell">
        <?= $content ?>
    </main>
</body>

</html>