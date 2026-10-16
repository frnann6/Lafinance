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

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


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

        .btn.btn-add:active,
        .btn.btn-add:focus {
            background-color: #14532d;
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

        /* ALERT */

        .toast-alert {
            position: fixed;
            top: 16px;
            left: 50%;
            z-index: 2000;
            width: min(92vw, 420px);
            transform: translateX(-50%);
            animation: toastIn 0.35s ease-out;
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translate(-50%, -18px);
            }

            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }

        /* MODAL */


        /* Modal tambah transaksi: mobile-first */
        #transactionModal .modal-dialog {
            width: auto;
            max-width: 480px;
            margin: 12px auto;
        }

        #transactionModal .modal-content {
            border-radius: 24px !important;
            overflow: hidden;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        }

        #transactionModal .modal-header {
            padding: 22px 20px 0;
        }

        #transactionModal .modal-body {
            padding: 20px;
        }

        #transactionModal .modal-title {
            font-size: 1.2rem !important;
            letter-spacing: -0.3px;
        }

        #transactionModal .form-label {
            font-size: 0.9rem;
            margin-bottom: 8px;
            color: #26352c;
        }

        #transactionModal .form-control,
        #transactionModal .form-select {
            min-height: 48px;
            border: 1px solid #dfe7e1;
            background-color: #fbfdfb;
            font-size: 16px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        #transactionModal textarea.form-control {
            min-height: 90px;
            resize: vertical;
        }

        #transactionModal .form-control:focus,
        #transactionModal .form-select:focus {
            border-color: #279764;
            box-shadow: 0 0 0 3px rgba(39, 151, 100, 0.12);
            background-color: #fff;
        }

        /* #transactionModal #amount {
            font-size: 1.15rem;
            font-weight: 600;
        } */

        #transactionModal .btn-add {
            min-height: 50px;
            border-radius: 14px;
            font-size: 1rem;
            font-weight: 600;
        }

        #transactionModal .btn-light {
            min-height: 46px;
            border: 1px solid #e6ebe7;
            border-radius: 12px !important;
        }

        @media (max-width: 576px) {
            #transactionModal .modal-dialog {
                max-width: none;
                margin: 10px;
                min-height: calc(100% - 20px);
            }

            #transactionModal .modal-content {
                border-radius: 22px !important;
            }

            #transactionModal .modal-header {
                padding: 20px 18px 0;
            }

            #transactionModal .modal-body {
                padding: 18px;
            }

            #transactionModal .mb-3 {
                margin-bottom: 18px !important;
            }

            #transactionModal .modal-body form>.mb-4 {
                margin-bottom: 20px !important;
            }
        }


        /* Pilihan jenis transaksi */
        #transactionModal .transaction-type-picker {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        #transactionModal .transaction-type-option {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 64px;
            padding: 12px;
            border: 1.5px solid #dfe7e1;
            border-radius: 16px;
            background: #fbfdfb;
            color: #526157;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        #transactionModal .transaction-type-option .type-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            border-radius: 11px;
            background: #edf1ee;
            font-size: 1.2rem;
        }

        #transactionModal .transaction-type-option.active[data-type="income"] {
            color: #167344;
            background: #eaf8ef;
            border-color: #279764;
        }

        #transactionModal .transaction-type-option.active[data-type="income"] .type-icon {
            background: #d4f0df;
        }

        #transactionModal .transaction-type-option.active[data-type="expense"] {
            color: #b42332;
            background: #fff0f0;
            border-color: #dc5864;
        }

        #transactionModal .transaction-type-option.active[data-type="expense"] .type-icon {
            background: #ffdddd;
        }

        #transactionModal .transaction-type-option:focus-visible {
            outline: 3px solid rgba(39, 151, 100, 0.25);
            outline-offset: 2px;
        }

        #transactionModal .transaction-type-option:active {
            transform: scale(0.98);
        }
    </style>
</head>

<body>
    <main class="app-container">

        <div class="d-flex align-items-center gap-2">
            <img src="<?= base_url('assets/img/logos/lafern-circle.png') ?>" width="35px" height="auto" alt="">
            <header class="brand">Lafinance</header>
        </div>


        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show mt-3 toast-alert" role="alert">
                <?= esc(session()->getFlashdata('error')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success alert-dismissible fade show mt-3 toast-alert" role="alert">
                <?= esc(session()->getFlashdata('message')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        <?php endif; ?>


        <section>
            <h1 class="page-title">Transaksi</h1>
            <p class="muted mb-0">
                Catat dan pantau pemasukan serta pengeluaranmu.
            </p>
        </section>

        <button type="button" class="btn btn-add w-100 mt-4 btn-tambah-transaksi"
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
                                <label class="form-label fw-semibold">
                                    Jenis transaksi
                                </label>

                                <input type="hidden" name="type" id="type"
                                    value="<?= esc(old('type', 'income')) ?>">

                                <div class="transaction-type-picker">
                                    <button type="button"
                                        class="transaction-type-option"
                                        data-type="income">
                                        <span class="type-icon">
                                            <i class="bi bi-arrow-up-right"></i>
                                            <!-- <i class="bi bi-graph-up-arrow"></i> -->
                                        </span>
                                        <span>Pemasukan</span>
                                    </button>

                                    <button type="button"
                                        class="transaction-type-option"
                                        data-type="expense">
                                        <span class="type-icon">
                                            <i class="bi bi-arrow-down-right"></i>
                                            <!-- <i class="bi bi-graph-down-arrow"></i> -->
                                        </span>
                                        <span>Pengeluaran</span>
                                    </button>
                                </div>
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
                                <label for="amount_display" class="form-label fw-semibold">
                                    Nominal transaksi
                                </label>

                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light fw-semibold" style="font-size: 15px;">Rp</span>
                                    <input type="text"
                                        id="amount_display"
                                        class="form-control rounded-end-3"
                                        inputmode="numeric"
                                        autocomplete="off"
                                        placeholder="0"
                                        value="<?= esc(old('amount') !== null && old('amount') !== '' ? number_format((float) old('amount'), 0, ',', '.') : '') ?>"
                                        required>
                                </div>

                                <input type="hidden"
                                    name="amount"
                                    id="amount"
                                    value="<?= esc(old('amount') ?? '') ?>">

                                <small class="text-secondary d-block mt-2">
                                    Masukkan nominal dalam Rupiah.
                                </small>
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


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const typeButtons = document.querySelectorAll(
                '#transactionModal .transaction-type-option'
            );
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

            function updateTypeButtons() {
                typeButtons.forEach(function(button) {
                    const active = button.dataset.type === typeSelect.value;

                    button.classList.toggle('active', active);
                    button.setAttribute('aria-pressed', active ? 'true' : 'false');
                });
            }

            function updateCategories() {
                categorySelect.innerHTML =
                    '<option value="">Pilih kategori</option>';

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

                categorySelect.value = '';
                customInput.value = '';
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

            typeButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const newType = button.dataset.type;

                    if (typeSelect.value === newType) {
                        return;
                    }

                    typeSelect.value = newType;
                    updateTypeButtons();
                    updateCategories();
                });
            });

            categorySelect.addEventListener('change', syncCategory);

            customInput.addEventListener('input', function() {
                categoryInput.value = customInput.value.trim();
            });

            updateTypeButtons();
            updateCategories();

            if (categorySelect.value === '__custom__') {
                customInput.focus();
            }


            const amountDisplay = document.getElementById('amount_display');
            const amountInput = document.getElementById('amount');

            amountDisplay.addEventListener('input', function() {
                const digits = this.value.replace(/\D/g, '');

                this.value = digits ?
                    new Intl.NumberFormat('id-ID').format(Number(digits)) :
                    '';

                amountInput.value = digits;
            });

        });
    </script>

    ```
</body>

</html>