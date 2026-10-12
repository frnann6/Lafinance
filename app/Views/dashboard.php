<?php
$user = auth()->user();
$nama = $user?->username ?? 'Pengguna';
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#166534">
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

        .welcome {
            margin-top: 28px;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
            overflow-wrap: anywhere;
        }

        .muted {
            color: #6b7280;
            font-size: 14px;
        }

        .balance-card {
            margin-top: 24px;
            padding: 24px;
            color: white;
            background: var(--lafinance-green);
            border-radius: 24px;
        }

        .balance-label {
            color: #dcfce7;
            font-size: 14px;
        }

        .balance-value {
            margin: 12px 0 0;
            font-size: 30px;
            font-weight: 800;
        }

        .summary-card {
            height: 100%;
            padding: 18px 14px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
        }

        .summary-label {
            margin-top: 10px;
            color: #6b7280;
            font-size: 13px;
        }

        .summary-value {
            margin-top: 5px;
            font-size: 17px;
            font-weight: 750;
        }

        .section-title {
            font-size: 17px;
            font-weight: 750;
        }

        .transaction-card {
            margin-top: 16px;
            padding: 18px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
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
            background: white;
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
            <p class="muted mb-1 mt-4">Ringkasan keuanganmu</p>

            <h1 class="welcome">
                Halo, <?= esc($nama) ?>
            </h1>

            <p class="muted mb-0">
                Yuk, kelola keuanganmu hari ini.
            </p>
        </section>

        <section class="balance-card">
            <p class="balance-label mb-0">Total Saldo</p>
            <p class="balance-value">Rp0</p>
            <p class="balance-label mb-0">
                Ringkasan saldo akan tersedia setelah transaksi dicatat.
            </p>
        </section>

        <section class="row g-3 mt-1">
            <div class="col-6">
                <div class="summary-card">
                    <div class="text-success fs-4">↗</div>
                    <div class="summary-label">Pemasukan</div>
                    <div class="summary-value">Rp0</div>
                </div>
            </div>

            <div class="col-6">
                <div class="summary-card">
                    <div class="text-danger fs-4">↘</div>
                    <div class="summary-label">Pengeluaran</div>
                    <div class="summary-value">Rp0</div>
                </div>
            </div>
        </section>

        <section class="transaction-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="section-title mb-0">Transaksi Terbaru</h2>
            </div>

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

                            <div class="amount fw-bold text-success <?= $transaction['type'] === 'income' ? 'income' : 'expense' ?>">
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
        </section>

        <div class="mt-4">
            <a href="<?= url_to('logout') ?>"
                class="btn btn-outline-danger w-100 rounded-3 py-2">
                Keluar dari akun
            </a>
        </div>

    </main>

    <?= $this->include('partials/navbar', ['activeMenu' => 'home']) ?>

</body>

</html>