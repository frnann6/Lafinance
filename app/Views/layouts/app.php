<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#166534">

    <link rel="shortcut icon" href="<?= base_url('assets/img/logos/lafern-circle.png') ?>" type="image/x-icon">
    <title>Dashboard | Lafinance</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        :root {
            --lafinance-green: #166534;
            --lafinance-bg: #f5f8f5;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--lafinance-bg);
            color: #1f2937;
            font-family: system-ui, -apple-system, sans-serif;
        }

        .app-container {
            width: 100%;
            max-width: 430px;
            min-height: 100vh;
            margin: 0 auto;
            padding: 28px 20px 100px;
        }

        .brand {
            color: var(--lafinance-green);
            font-size: 20px;
            font-weight: 800;
        }
    </style>
</head>

<body>

    <main class="app-container">

        <div class="d-flex align-items-center gap-2">
            <img src="<?= base_url('assets/img/logos/lafern-circle.png') ?>" width="35px" height="auto" alt="">
            <header class="brand">Lafinance</header>
        </div>

    </main>

</body>

</html>