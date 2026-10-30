<?php
$displayName = trim((string) ($displayName ?? ''));
$displayName = $displayName !== '' ? $displayName : 'Pengguna';
$initial = strtoupper(substr($displayName, 0, 1));
$photoPath = $photoPath ?? null;
?>
<!doctype html>
<html lang="id" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#166534">

    <link rel="shortcut icon" href="<?= base_url('assets/img/logos/lafern-circle.png') ?>" type="image/x-icon">
    <title>Transaksi | Lafinance</title>

    <script>
        (function () {
            var theme = localStorage.getItem('lafinance_theme');
            document.documentElement.setAttribute('data-bs-theme', theme === 'dark' ? 'dark' : 'light');
        })();
    </script>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/css/transactions.css') ?>">
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
                <article
                    class="transaction-card"
                    role="button"
                    tabindex="0"
                    data-bs-toggle="modal"
                    data-bs-target="#transactionDetailModal"
                    data-id="<?= esc((string) $transaction['id'], 'attr') ?>"
                    data-type="<?= esc($transaction['type'], 'attr') ?>"
                    data-category="<?= esc($transaction['category'], 'attr') ?>"
                    data-amount="<?= esc((string) $transaction['amount'], 'attr') ?>"
                    data-date="<?= esc(date('d M Y', strtotime($transaction['transaction_date'])), 'attr') ?>"
                    data-date-iso="<?= esc($transaction['transaction_date'], 'attr') ?>"
                    data-description="<?= esc($transaction['description'] ?? '', 'attr') ?>">
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

                        <form action="<?= site_url('dashboard/transactions/store') ?>"
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
                                    <span class="input-group-text amount-prefix fw-semibold" style="font-size: 15px;">Rp</span>
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

        <!-- Modal Edit Transaksi -->
        <div class="modal fade" id="editTransactionModal" tabindex="-1"
            aria-labelledby="editTransactionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 rounded-4">
                    <div class="modal-header border-0 pb-0">
                        <div>
                            <h2 class="modal-title fs-5 fw-bold" id="editTransactionModalLabel">Edit Transaksi</h2>
                            <p class="text-secondary small mb-0">Perbarui detail transaksi pilihanmu.</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body pt-3">
                        <form id="editTransactionForm" method="post" action="">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="edit_type" class="form-label fw-semibold">Jenis transaksi</label>
                                <select class="form-select rounded-3 py-2" id="edit_type" name="type" required>
                                    <option value="income">Pemasukan</option>
                                    <option value="expense">Pengeluaran</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_category" class="form-label fw-semibold">Kategori</label>
                                <input class="form-control rounded-3 py-2" id="edit_category" name="category" maxlength="100" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_amount_display" class="form-label fw-semibold">
                                    Nominal transaksi
                                </label>

                                <div class="input-group input-group-lg">
                                    <span class="input-group-text amount-prefix fw-semibold" style="font-size: 15px;">
                                        Rp
                                    </span>
                                    <input
                                        type="text"
                                        id="edit_amount_display"
                                        class="form-control rounded-end-3"
                                        inputmode="numeric"
                                        autocomplete="off"
                                        placeholder="0"
                                        required>
                                </div>

                                <input type="hidden" id="edit_amount" name="amount" value="">

                                <small class="text-secondary d-block mt-2">
                                    Masukkan nominal dalam Rupiah.
                                </small>
                            </div>

                            <div class="mb-3">
                                <label for="edit_transaction_date" class="form-label fw-semibold">Tanggal</label>
                                <input class="form-control rounded-3 py-2" id="edit_transaction_date" name="transaction_date" type="date" required>
                            </div>
                            <div class="mb-4">
                                <label for="edit_description" class="form-label fw-semibold">Catatan <span class="text-secondary fw-normal">(opsional)</span></label>
                                <textarea class="form-control rounded-3" id="edit_description" name="description" rows="3" maxlength="1000" placeholder="Tambahkan catatan jika perlu"></textarea>
                            </div>
                            <button type="submit" class="btn btn-add w-100 py-3">Simpan Perubahan</button>
                            <button type="button" class="btn btn-light w-100 mt-2 rounded-3 py-2" data-bs-dismiss="modal">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Konfirmasi Hapus -->
        <div class="modal fade" id="deleteTransactionModal" tabindex="-1"
            aria-labelledby="deleteTransactionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-4">
                    <div class="modal-body text-center p-4">
                        <div class="fs-1 text-danger mb-2"><i class="bi bi-trash3"></i></div>
                        <h2 class="h5 fw-bold" id="deleteTransactionModalLabel">Hapus transaksi?</h2>
                        <p class="text-secondary mb-4">Transaksi yang dihapus tidak dapat dikembalikan.</p>
                        <form id="deleteTransactionForm" method="post" action="">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-danger w-100 rounded-3 py-2">Ya, Hapus Transaksi</button>
                            <button type="button" class="btn btn-light w-100 mt-2 rounded-3 py-2" data-bs-dismiss="modal">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Detail Transaksi -->
        <div class="modal fade" id="transactionDetailModal"
            tabindex="-1" aria-labelledby="transactionDetailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <div>
                            <h2 class="modal-title fs-5 fw-bold" id="transactionDetailModalLabel">
                                Detail Transaksi
                            </h2>
                            <p class="text-secondary small mb-0">
                                Informasi transaksi yang kamu pilih.
                            </p>
                        </div>
                        <button type="button" class="btn-close"
                            data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body px-4 pt-3 pb-4">
                        <div class="detail-summary rounded-4 p-3 mb-3">
                            <div class="small text-secondary mb-1" id="detailType"></div>
                            <div class="fs-4 fw-bold" id="detailAmount"></div>
                            <div class="fw-semibold mt-1" id="detailCategory"></div>
                        </div>

                        <div class="detail-row">
                            <div class="small text-secondary mb-1">Tanggal</div>
                            <div class="fw-semibold" id="detailDate">-</div>
                        </div>
                        <div class="detail-row">
                            <div class="small text-secondary mb-1">Catatan</div>
                            <div id="detailDescription" style="white-space:pre-wrap; overflow-wrap:anywhere;">-</div>
                        </div>

                        <div class="detail-row d-flex align-items-center gap-2 added-by">
                            <span class="added-by-avatar" aria-hidden="true">
                                <?php if (! empty($photoPath)): ?>
                                    <img src="<?= esc(base_url($photoPath), 'attr') ?>" alt="">
                                <?php else: ?>
                                    <?= esc($initial) ?>
                                <?php endif; ?>
                            </span>
                            <span>Ditambahkan oleh <span class="fw-semibold"><?= esc($displayName) ?></span></span>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button"
                                class="btn btn-outline-success rounded-5 py-2"
                                id="editTransactionButton">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button type="button"
                                class="btn btn-outline-danger rounded-5 py-2"
                                id="deleteTransactionButton">
                                <i class="bi bi-trash3"></i> Delete
                            </button>
                        </div>

                        <!-- <button type="button" class="btn btn-light w-100 mt-4 rounded-3 py-2"
                            data-bs-dismiss="modal">
                            Tutup
                        </button> -->
                    </div>
                </div>
            </div>
        </div>

    </main>

    <?= $this->include('partials/navbar', ['activeMenu' => 'transactions']) ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const detailModal = document.getElementById('transactionDetailModal');
            const editModalElement = document.getElementById('editTransactionModal');
            const deleteModalElement = document.getElementById('deleteTransactionModal');
            const editModal = bootstrap.Modal.getOrCreateInstance(editModalElement);
            const deleteModal = bootstrap.Modal.getOrCreateInstance(deleteModalElement);
            let selectedTransaction = null;

            detailModal.addEventListener('show.bs.modal', function(event) {
                const card = event.relatedTarget;
                if (card && card.dataset) selectedTransaction = card;
            });

            document.getElementById('editTransactionButton').addEventListener('click', function() {
                if (!selectedTransaction) return;
                const card = selectedTransaction;
                document.getElementById('editTransactionForm').action =
                    <?= json_encode(site_url('dashboard/transactions/update')) ?> + '/' + encodeURIComponent(card.dataset.id);
                document.getElementById('edit_type').value = card.dataset.type || 'income';
                document.getElementById('edit_category').value = card.dataset.category || '';

                const editAmount = card.dataset.amount || '';

                document.getElementById('edit_amount').value = editAmount;
                document.getElementById('edit_amount_display').value = editAmount ?
                    new Intl.NumberFormat('id-ID').format(Number(editAmount)) :
                    '';

                document.getElementById('edit_transaction_date').value = card.dataset.dateIso || '';
                document.getElementById('edit_description').value = card.dataset.description || '';
                bootstrap.Modal.getOrCreateInstance(detailModal).hide();
                detailModal.addEventListener('hidden.bs.modal', function openEditOnce() {
                    detailModal.removeEventListener('hidden.bs.modal', openEditOnce);
                    editModal.show();
                });
            });

            document.getElementById('deleteTransactionButton').addEventListener('click', function() {
                if (!selectedTransaction) return;
                document.getElementById('deleteTransactionForm').action =
                    <?= json_encode(site_url('dashboard/transactions/delete')) ?> + '/' + encodeURIComponent(selectedTransaction.dataset.id);
                bootstrap.Modal.getOrCreateInstance(detailModal).hide();
                detailModal.addEventListener('hidden.bs.modal', function openDeleteOnce() {
                    detailModal.removeEventListener('hidden.bs.modal', openDeleteOnce);
                    deleteModal.show();
                });
            });

            detailModal.addEventListener('show.bs.modal', function(event) {
                const card = event.relatedTarget;
                if (!card) return;

                const isIncome = card.dataset.type === 'income';
                const amount = Number(card.dataset.amount || 0);

                document.getElementById('detailType').textContent =
                    isIncome ? 'Pemasukan' : 'Pengeluaran';

                const amountElement = document.getElementById('detailAmount');
                amountElement.textContent =
                    (isIncome ? '+ Rp' : '− Rp') +
                    new Intl.NumberFormat('id-ID', {
                        maximumFractionDigits: 0
                    }).format(amount);
                amountElement.style.color = isIncome ? '#15803d' : '#dc2626';

                document.getElementById('detailCategory').textContent =
                    card.dataset.category || '-';
                document.getElementById('detailDate').textContent =
                    card.dataset.date || '-';
                document.getElementById('detailDescription').textContent =
                    card.dataset.description || 'Tidak ada catatan.';
            });

            document.querySelectorAll('.transaction-card[role="button"]').forEach(function(card) {
                card.addEventListener('keydown', function(event) {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        bootstrap.Modal.getOrCreateInstance(
                            document.getElementById('transactionDetailModal')
                        ).show(card);
                    }
                });
            });
        });
    </script>

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


            const amountFormatter = new Intl.NumberFormat('id-ID');

            const editAmountDisplay = document.getElementById('edit_amount_display');
            const editAmountInput = document.getElementById('edit_amount');

            editAmountDisplay.addEventListener('input', function() {
                const digits = this.value.replace(/\D/g, '');

                this.value = digits ?
                    amountFormatter.format(Number(digits)) :
                    '';

                editAmountInput.value = digits;
            });


        });
    </script>

</body>

</html>