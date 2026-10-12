<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Transaksi | Lafinance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <style>
        body {
            background: #f5f8f5;
            color: #1f2937;
            font-family: system-ui, sans-serif;
        }

        .app-container {
            max-width: 430px;
            min-height: 100vh;
            margin: auto;
            padding: 28px 20px;
        }

        .brand {
            color: #166534;
            font-size: 20px;
            font-weight: 800;
        }

        .form-card {
            margin-top: 24px;
            padding: 22px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 22px;
        }

        .form-label {
            font-size: 14px;
            font-weight: 650;
        }

        .form-control,
        .form-select {
            min-height: 48px;
            border-radius: 12px;
        }

        .btn-success {
            min-height: 48px;
            border-radius: 12px;
            background: #166534;
        }
    </style>
</head>

<body>
    <main class="app-container">
        <header class="brand">Lafinance</header>

        <h1 class="h3 fw-bold mt-4">Tambah Transaksi</h1>
        <p class="text-secondary small">Catat pemasukan atau pengeluaranmu.</p>

        <?php if (session('errors')): ?>
            <div class="alert alert-danger rounded-3">
                <?php foreach (session('errors') as $error): ?>
                    <div><?= esc($error) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('transactions/store') ?>"
            method="post" class="form-card">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="type" class="form-label">Jenis transaksi</label>
                <select name="type" id="type" class="form-select" required>
                    <option value="income" <?= old('type') === 'income' ? 'selected' : '' ?>>
                        Pemasukan
                    </option>
                    <option value="expense" <?= old('type') === 'expense' ? 'selected' : '' ?>>
                        Pengeluaran
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Kategori</label>
                <input type="text" name="category" id="category"
                    class="form-control" maxlength="100"
                    placeholder="Contoh: Gaji, Makanan" required
                    value="<?= esc(old('category') ?? '') ?>">
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">Nominal (Rp)</label>
                <input type="number" name="amount" id="amount"
                    class="form-control" min="0.01" step="0.01"
                    inputmode="decimal" placeholder="Contoh: 50000" required
                    value="<?= esc(old('amount') ?? '') ?>">
            </div>

            <div class="mb-3">
                <label for="transaction_date" class="form-label">Tanggal</label>
                <input type="date" name="transaction_date"
                    id="transaction_date" class="form-control" required
                    value="<?= esc(old('transaction_date') ?? date('Y-m-d')) ?>">
            </div>

            <div class="mb-4">
                <label for="description" class="form-label">
                    Catatan <span class="text-secondary fw-normal">(opsional)</span>
                </label>
                <textarea name="description" id="description"
                    class="form-control" rows="3"
                    placeholder="Tambahkan catatan jika perlu"><?= esc(old('description') ?? '') ?></textarea>
            </div>

            <button type="submit" class="btn btn-success text-white w-100 fw-bold">
                Simpan Transaksi
            </button>

            <a href="<?= site_url('transactions') ?>"
                class="btn btn-light w-100 mt-2 rounded-3 py-2">
                Batal
            </a>
        </form>
    </main>
</body>

</html>