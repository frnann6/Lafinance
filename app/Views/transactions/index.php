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

        <div class="d-flex align-items-center gap-2">
            <img src="<?= base_url('assets/img/logos/lafern-circle.png') ?>" width="35px" height="auto" alt="">
            <header class="brand">Lafinance</header>
        </div>

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

        <button type="button" class="btn btn-add w-100 mt-4"
            data-bs-toggle="modal"
            data-bs-target="#transactionModal">
            + Tambah Transaksi
        </button>

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

        <!-- Modal Tambah Transaksi -->
        <div class="modal fade" id="transactionModal"
            tabindex="-1" aria-labelledby="transactionModalLabel"
            aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 rounded-4">

                    <div class="modal-header border-0 pb-0">
                        <div>
                            <h2 class="modal-title fs-5 fw-bold"
                                id="transactionModalLabel">
                                Tambah Transaksi
                            </h2>
                            <p class="text-secondary small mb-0">
                                Catat pemasukan atau pengeluaranmu.
                            </p>
                        </div>

                        <button type="button" class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body pt-3">

                        <?php if (session('errors')): ?>
                            <div class="alert alert-danger rounded-3">
                                <?php foreach (session('errors') as $error): ?>
                                    <div><?= esc($error) ?></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= site_url('transactions/store') ?>"
                            method="post">

                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="type" class="form-label fw-semibold">
                                    Jenis transaksi
                                </label>

                                <select name="type" id="type"
                                    class="form-select rounded-3 py-2" required>
                                    <option value="income"
                                        <?= old('type', 'income') === 'income' ? 'selected' : '' ?>>
                                        Pemasukan
                                    </option>
                                    <option value="expense"
                                        <?= old('type') === 'expense' ? 'selected' : '' ?>>
                                        Pengeluaran
                                    </option>
                                </select>
                            </div>

                            <?php
                            $jenisLama = old('type', 'income');
                            $kategoriLama = old('category', '');
                            $kategoriBawaan = [
                                'income' => [
                                    'Gaji',
                                    'Bisnis',
                                    'Freelance',
                                    'Investasi',
                                    'Bonus',
                                ],
                                'expense' => [
                                    'Makanan',
                                    'Transportasi',
                                    'Belanja',
                                    'Tagihan',
                                    'Pendidikan',
                                    'Kesehatan',
                                    'Hiburan',
                                ],
                            ];

                            $kategoriKhusus = $kategoriLama !== ''
                                && ! in_array($kategoriLama, array_merge(
                                    $kategoriBawaan['income'],
                                    $kategoriBawaan['expense']
                                ), true);
                            ?>

                            <div class="mb-3">
                                <label for="category" class="form-label fw-semibold">
                                    Kategori
                                </label>

                                <select id="category_select"
                                    class="form-select rounded-3 py-2">
                                    <option value="">Pilih kategori</option>
                                    <?php foreach ($kategoriBawaan[$jenisLama] as $kategori): ?>
                                        <option value="<?= esc($kategori) ?>"
                                            <?= $kategoriLama === $kategori ? 'selected' : '' ?>>
                                            <?= esc($kategori) ?>
                                        </option>
                                    <?php endforeach; ?>
                                    <option value="__custom__"
                                        <?= $kategoriKhusus ? 'selected' : '' ?>>
                                        Lainnya
                                    </option>
                                </select>

                                <input type="hidden" name="category" id="category"
                                    value="<?= $kategoriKhusus ? '' : esc($kategoriLama) ?>">

                                <input type="text" id="custom_category"
                                    class="form-control rounded-3 mt-2 <?= $kategoriKhusus ? '' : 'd-none' ?>"
                                    maxlength="100"
                                    placeholder="Kategori lainnya.."
                                    value="<?= $kategoriKhusus ? esc($kategoriLama) : '' ?>"
                                    <?= $kategoriKhusus ? 'required' : '' ?>>
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label fw-semibold">
                                    Nominal (Rp)
                                </label>

                                <input type="number" name="amount" id="amount"
                                    class="form-control rounded-3 py-2"
                                    min="0.01" step="0.01"
                                    inputmode="decimal"
                                    placeholder="Contoh: 50000"
                                    value="<?= esc(old('amount') ?? '') ?>"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="transaction_date"
                                    class="form-label fw-semibold">
                                    Tanggal
                                </label>

                                <input type="date" name="transaction_date"
                                    id="transaction_date"
                                    class="form-control rounded-3 py-2"
                                    value="<?= esc(old('transaction_date') ?? date('Y-m-d')) ?>"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label for="description"
                                    class="form-label fw-semibold">
                                    Catatan
                                    <span class="text-secondary fw-normal">
                                        (opsional)
                                    </span>
                                </label>

                                <textarea name="description" id="description"
                                    class="form-control rounded-3"
                                    rows="3"
                                    placeholder="Tambahkan catatan jika perlu"><?= esc(old('description') ?? '') ?></textarea>
                            </div>

                            <button type="submit"
                                class="btn btn-add w-100 py-3">
                                Simpan Transaksi
                            </button>

                            <button type="button"
                                class="btn btn-light w-100 mt-2 rounded-3 py-2"
                                data-bs-dismiss="modal">
                                Batal
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <?= $this->include('partials/navbar', ['activeMenu' => 'home']) ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php if (session('errors')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modalElement = document.getElementById('transactionModal');
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            });
        </script>
    <?php endif; ?>

    ```html
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const categorySelect = document.getElementById('category_select');
            const categoryInput = document.getElementById('category');
            const customInput = document.getElementById('custom_category');

            const categories = {
                income: [
                    'Gaji',
                    'Bisnis',
                    'Freelance',
                    'Investasi',
                    'Bonus'
                ],
                expense: [
                    'Makanan',
                    'Transportasi',
                    'Belanja',
                    'Tagihan',
                    'Pendidikan',
                    'Kesehatan',
                    'Hiburan'
                ]
            };

            function updateCategories() {
                const previousValue = categorySelect.value;

                categorySelect.innerHTML = '<option value="">Pilih kategori</option>';

                (categories[typeSelect.value] || []).forEach(function(category) {
                    const option = document.createElement('option');
                    option.value = category;
                    option.textContent = category;
                    categorySelect.appendChild(option);
                });

                const customOption = document.createElement('option');
                customOption.value = '__custom__';
                customOption.textContent = 'Lainnya';
                categorySelect.appendChild(customOption);

                if ([...categorySelect.options].some(option => option.value === previousValue)) {
                    categorySelect.value = previousValue;
                }

                syncCategory();
            }

            function syncCategory() {
                const isCustom = categorySelect.value === '__custom__';

                customInput.classList.toggle('d-none', !isCustom);
                customInput.required = isCustom;

                if (isCustom) {
                    categoryInput.value = customInput.value.trim();
                } else {
                    categoryInput.value = categorySelect.value;
                    customInput.value = '';
                }
            }

            typeSelect.addEventListener('change', function() {
                categorySelect.value = '';
                customInput.value = '';
                updateCategories();
            });

            categorySelect.addEventListener('change', syncCategory);

            customInput.addEventListener('input', function() {
                categoryInput.value = customInput.value.trim();
            });

            updateCategories();

            if (categorySelect.value === '__custom__') {
                customInput.focus();
            }
        });
    </script>
    ```
</body>

</html>