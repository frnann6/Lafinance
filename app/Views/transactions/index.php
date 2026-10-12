<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#166534">

    <link rel="shortcut icon" href="<?= base_url('assets/img/logos/lafern-circle.png') ?>" type="image/x-icon">
    <title>Transaksi | Lafinance</title>

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
            padding: 28px 20px 110px;
        }

        .brand {
            color: var(--lafinance-green);
            font-size: 20px;
            font-weight: 800;
        }

        .page-title {
            margin-top: 28px;
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .muted {
            color: #6b7280;
            font-size: 14px;
        }

        .transaction-card {
            margin-top: 16px;
            padding: 18px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
        }

        .amount {
            font-size: 15px;
            font-weight: 750;
            white-space: nowrap;
        }

        .income {
            color: #15803d;
        }

        .expense {
            color: #dc2626;
        }

        .btn-add {
            /* min-height: 48px; */
            border: 0;
            border-radius: 14px;
            background: var(--lafinance-green);
            color: #fff;
            font-weight: 700;
        }

        .btn-add:hover {
            background: #14532d;
            color: #fff;
        }

        .bottom-nav {
            position: fixed;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 10;
            max-width: 430px;
            margin: 0 auto;
            padding: 14px 10px calc(14px + env(safe-area-inset-bottom));
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
            color: var(--lafinance-green);
            font-weight: 700;
        }

        .nav-icon {
            display: block;
            margin-bottom: 4px;
            font-size: 19px;
        }
    </style>
</head>

<body>
    <main class="app-container">

        <header class="brand">Lafinance</header>

        <section>
            <h1 class="page-title">Transaksi</h1>
            <p class="muted mb-0">
                Catat dan pantau pemasukan serta pengeluaranmu.
            </p>
        </section>

        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success rounded-3 mt-3">
                <?= esc(session()->getFlashdata('message')) ?>
            </div>
        <?php endif; ?>

        <a href="<?= site_url('transactions/create') ?>"
            class="btn btn-add w-100 mt-4">
            + Tambah Transaksi
        </a>

        <?php if (empty($transactions)): ?>

            <section class="transaction-card text-center py-5">
                <div class="fs-1 mb-3">🧾</div>
                <h2 class="h6 fw-bold">Belum ada transaksi</h2>
                <p class="muted mb-0">
                    Transaksi yang kamu catat akan muncul di sini.
                </p>
            </section>

        <?php else: ?>

            <?php foreach ($transactions as $transaction): ?>
                <article class="transaction-card">
                    <div class="d-flex justify-content-between align-items-start gap-3">

                        <div class="flex-grow-1">
                            <h2 class="h6 fw-bold mb-1">
                                <?= esc($transaction['category']) ?>
                            </h2>

                            <p class="muted mb-1">
                                <?= esc(date(
                                    'd M Y',
                                    strtotime($transaction['transaction_date'])
                                )) ?>
                            </p>

                            <?php if (! empty($transaction['description'])): ?>
                                <p class="muted mb-0">
                                    <?= esc($transaction['description']) ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div class="amount <?= $transaction['type'] === 'income' ? 'income' : 'expense' ?>">
                            <?= $transaction['type'] === 'income' ? '+' : '−' ?>
                            Rp<?= esc(number_format(
                                    (float) $transaction['amount'],
                                    0,
                                    ',',
                                    '.'
                                )) ?>
                        </div>

                    </div>
                </article>
            <?php endforeach; ?>

        <?php endif; ?>

    </main>

    <?= $this->include('partials/navbar', ['activeMenu' => 'home']) ?>

</body>

</html>