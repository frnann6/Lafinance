<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="<?= base_url('assets/img/logos/lafern-circle.png') ?>" type="image/x-icon">
    <title><?= esc($this->renderSection('title')) ?> | Lafinance</title>

    <meta name="theme-color" content="#166534">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets/css/shield-layout.css') ?>">

    <?= $this->renderSection('pageStyles') ?>
</head>

<body>
    <main class="auth-shell">
        <header class="brand">
            <!-- <div class="brand-icon" aria-hidden="true">▣</div> -->
            <div aria-hidden="true"><img class="my-2 rounded-circle" width="55" height="55" src="<?= base_url('assets/img/logos/lafern.png') ?>"></div>
            <h1 class="brand-name">Lafinance</h1>
            <p class="brand-description">
                Atur keuanganmu dengan lebih mudah
            </p>
        </header>

        <section class="auth-card">
            <?= $this->renderSection('main') ?>
        </section>

        <footer class="auth-footer">
            Keuangan lebih teratur, hidup lebih tenang.
        </footer>
    </main>

    <?= $this->renderSection('pageScripts') ?>
</body>

</html>