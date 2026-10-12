<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#166534">
    <title><?= esc($title ?? 'DuitKu') ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            background: #f5f8f5;
            color: #1f2937;
            font-family: system-ui, sans-serif;
        }

        .app-container {
            width: 100%;
            max-width: 430px;
            min-height: 100vh;
            margin: 0 auto;
            padding: 24px 20px 100px;
        }

        .brand {
            color: #166534;
            font-size: 20px;
            font-weight: 800;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            display: flex;
            justify-content: space-around;
            width: 100%;
            max-width: 430px;
            padding: 12px 8px calc(12px + env(safe-area-inset-bottom));
            background: #fff;
            border-top: 1px solid #e5e7eb;
        }

        .nav-item {
            flex: 1;
            color: #6b7280;
            font-size: 12px;
            text-align: center;
            text-decoration: none;
        }

        .nav-item.active {
            color: #166534;
            font-weight: 700;
        }

        .nav-icon {
            display: block;
            margin-bottom: 4px;
            font-size: 20px;
        }
    </style>
</head>

<body>

    <main class="app-container">
        <header class="brand mb-4">DuitKu</header>

        <?= $this->renderSection('content') ?>
    </main>

    <?= $this->include('partials/navbar') ?>

</body>

</html>