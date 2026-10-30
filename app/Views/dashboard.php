<?php
$user = auth()->user();
$nama = $user?->username ?? 'Pengguna';
$initial = strtoupper(substr(trim($nama), 0, 1));
$photoPath = $photoPath ?? null;
?>

<!doctype html>
<html lang="id" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#166534">

    <link rel="shortcut icon" href="<?= base_url('assets/img/logos/lafern-circle.png') ?>" type="image/x-icon">
    <title>Dashboard | Lafinance</title>

    <script>
        (function () {
            var theme = localStorage.getItem('lafinance_theme');
            document.documentElement.setAttribute('data-bs-theme', theme === 'dark' ? 'dark' : 'light');
        })();
    </script>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">
</head>

<body>

    <main class="app-container">

        <div class="d-flex align-items-center gap-2">
            <img src="<?= base_url('assets/img/logos/lafern-circle.png') ?>" width="35px" height="auto" alt="">
            <header class="brand">Lafinance</header>
        </div>

        <section>
            <p class="muted mb-1 mt-4">Ringkasan keuanganmu</p>

            <div class="welcome-row d-flex align-items-center gap-3">
                <a href="<?= site_url('dashboard/profile') ?>" class="welcome-avatar"
                    aria-label="Buka profil <?= esc($nama, 'attr') ?>">
                    <?php if (! empty($photoPath)): ?>
                        <img src="<?= esc(base_url($photoPath), 'attr') ?>" alt="Foto profil <?= esc($nama, 'attr') ?>">
                    <?php else: ?>
                        <?= esc($initial) ?>
                    <?php endif; ?>
                </a>

                <div class="welcome-text">
                    <h1 class="welcome mb-0">
                        Halo, <?= esc($nama) ?>
                    </h1>

                    <p class="muted mb-0">
                        Yuk, kelola keuanganmu hari ini.
                    </p>
                </div>
            </div>
        </section>

        <section class="balance-card">
            <p class="balance-label mb-0">Total Saldo</p>
            <div class="d-flex align-items-center">
                <p class="balance-value mb-0" id="total-balance">
                    Rp <?= number_format($totalSaldo, 0, ',', '.') ?>
                </p>
                <button type="button" class="btn btn-white btn-hide" id="balance-toggle"
                    aria-label="Sembunyikan saldo" title="Sembunyikan saldo"
                    aria-controls="total-balance" aria-pressed="false">
                    <i class="bi bi-eye-slash text-white" aria-hidden="true"></i>
                </button>
            </div>
            <p class="balance-label mb-0">
                Ringkasan saldo akan tersedia setelah transaksi dicatat.
            </p>
        </section>

        <section class="row g-3 mt-1">
            <div class="col-6">
                <div class="summary-card">
                    <div class="text-success fs-4">↗</div>
                    <div class="summary-label">Pemasukan</div>
                    <div class="summary-value">
                        Rp <?= number_format($totalPemasukan, 0, ',', '.') ?>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="summary-card">
                    <div class="text-danger fs-4">↘</div>
                    <div class="summary-label">Pengeluaran</div>
                    <div class="summary-value">
                        Rp <?= number_format($totalPengeluaran, 0, ',', '.') ?>
                    </div>
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

                            <div class="amount fw-bold <?= $transaction['type'] === 'income' ? 'text-success' : 'text-danger' ?>">
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

    </main>

    <?= $this->include('partials/navbar', ['activeMenu' => 'home']) ?>

    <script>
        const balanceToggle = document.getElementById('balance-toggle');
        const totalBalance = document.getElementById('total-balance');
        const balanceIcon = balanceToggle.querySelector('i');
        const visibleBalance = totalBalance.textContent.trim();

        balanceToggle.addEventListener('click', () => {
            const isHidden = balanceToggle.getAttribute('aria-pressed') === 'true';

            totalBalance.textContent = isHidden ? visibleBalance : 'Rp •••••••';
            balanceToggle.setAttribute('aria-pressed', String(!isHidden));
            balanceToggle.setAttribute('aria-label', isHidden ? 'Sembunyikan saldo' : 'Tampilkan saldo');
            balanceToggle.setAttribute('title', isHidden ? 'Sembunyikan saldo' : 'Tampilkan saldo');
            balanceIcon.classList.toggle('bi-eye-slash', isHidden);
            balanceIcon.classList.toggle('bi-eye', !isHidden);
        });
    </script>

</body>

</html>