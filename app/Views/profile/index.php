<?php
$displayName = trim((string) ($username ?? 'Pengguna'));
$initial = strtoupper(substr($displayName, 0, 1));
$email = $email ?? '';
$totalIncome = (float) ($totalIncome ?? 0);
$totalExpense = (float) ($totalExpense ?? 0);
$balance = $totalIncome - $totalExpense;
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#166534">
    <link rel="shortcut icon" href="<?= base_url('assets/img/logos/lafern-circle.png') ?>" type="image/x-icon">
    <title>Profil | Lafinance</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.css">

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
            margin: 28px 0 4px;
            font-size: 25px;
            font-weight: 800;
        }

        .muted {
            color: #6b7280;
            font-size: 14px;
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

        .profile-panel,
        .summary-panel {
            margin-top: 20px;
            padding: 20px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
        }

        .profile-avatar {
            display: grid;
            width: 76px;
            height: 76px;
            flex: 0 0 76px;
            place-items: center;
            overflow: hidden;
            border-radius: 50%;
            background: #e8f3eb;
            color: var(--lafinance-green);
            font-size: 28px;
            font-weight: 800;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-name,
        .profile-email {
            overflow-wrap: anywhere;
        }

        .profile-name {
            font-size: 18px;
            font-weight: 750;
        }

        .photo-picker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 42px;
            padding: 8px 13px;
            border: 1px solid #d7e4d9;
            border-radius: 12px;
            background: #fff;
            color: var(--lafinance-green);
            font-size: 14px;
            font-weight: 650;
            cursor: pointer;
        }

        .photo-picker:hover {
            background: #f2f8f3;
        }

        .photo-delete-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 42px;
            padding: 8px 13px;
            border: 1px solid #d7e4d9;
            border-radius: 12px;
            background: #fff;
            color: #8B0000;
            font-size: 14px;
            font-weight: 650;
            cursor: pointer;
        }

        .photo-delete-button:hover {
            background: #f2f8f3;
        }

        .crop-panel {
            margin-top: 16px;
        }

        .crop-stage {
            width: 100%;
            height: min(68vw, 300px);
            min-height: 220px;
            max-height: 300px;
            overflow: hidden;
            border-radius: 14px;
            background: #202521;
        }

        .crop-stage img {
            display: block;
            max-width: 100%;
        }

        .crop-tools .btn {
            width: 42px;
            height: 42px;
            padding: 0;
        }

        .balance-value {
            margin: 5px 0 18px;
            color: var(--lafinance-green);
            font-size: 26px;
            font-weight: 800;
        }

        .summary-item {
            padding-top: 14px;
            border-top: 1px solid #edf0ed;
        }

        .summary-label {
            color: #6b7280;
            font-size: 13px;
        }

        .summary-value {
            margin-top: 4px;
            font-size: 15px;
            font-weight: 700;
        }

        .logout-button {
            min-height: 48px;
            margin-top: 20px;
            border-radius: 14px;
            font-weight: 650;
        }

        .btn-edit-usern {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            background: transparent !important;
            padding-bottom: 10px;
        }
    </style>
</head>

<body>
    <main class="app-container">
        <div class="d-flex align-items-center gap-2">
            <img src="<?= base_url('assets/img/logos/lafern-circle.png') ?>" width="35" height="35" alt="">
            <header class="brand">Lafinance</header>
        </div>

        <section>
            <h1 class="page-title">Profil</h1>
            <p class="muted mb-0">Informasi akun dan ringkasan keuanganmu.</p>
        </section>

        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success alert-dismissible fade show mt-3 toast-alert" role="alert">
                <?= esc(session()->getFlashdata('message')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show mt-3 toast-alert" role="alert">
                <?= esc(session()->getFlashdata('error')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        <?php endif; ?>

        <?php if (session('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show mt-3 toast-alert" role="alert">
                <?php foreach (session('errors') as $error): ?>
                    <div><?= esc($error) ?></div>
                <?php endforeach; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        <?php endif; ?>

        <section class="profile-panel" aria-label="Informasi akun">
            <div class="d-flex align-items-center gap-3">
                <div class="profile-avatar">
                    <?php if (! empty($photoPath)): ?>
                        <img src="<?= esc(base_url($photoPath), 'attr') ?>" alt="Foto profil <?= esc($displayName, 'attr') ?>">
                    <?php else: ?>
                        <?= esc($initial) ?>
                    <?php endif; ?>
                </div>
                <div class="min-w-0">
                    <div class="d-flex align-items-center">
                        <h2 class="profile-name mb-1"><?= esc($displayName) ?></h2>
                        <button type="button" class="btn btn-sm flex-shrink-0 btn-edit-usern"
                            data-bs-toggle="modal" data-bs-target="#editProfileModal"
                            aria-label="Edit username dan email" title="Edit profil">
                            <i class="bi bi-pencil" aria-hidden="true"></i>
                        </button>
                    </div>
                    <p class="profile-email muted mb-0"><?= esc($email ?: 'Email belum tersedia') ?></p>
                </div>
            </div>

            <form action="<?= site_url('dashboard/profile/photo') ?>" method="post" enctype="multipart/form-data" class="mt-3">
                <?= csrf_field() ?>
                <input type="file" name="photo" id="profile-photo" class="visually-hidden" accept="image/jpeg,image/png,image/webp" required>
                <label for="profile-photo" class="photo-picker">
                    <i class="bi bi-camera" aria-hidden="true"></i>
                    Pilih foto
                </label>
                <?php if (! empty($photoPath)): ?>
                    <button type="button" class="photo-delete-button ms-2"
                        data-bs-toggle="modal" data-bs-target="#deleteProfilePhotoModal">
                        <i class="bi bi-trash3 me-1" aria-hidden="true"></i>
                        Hapus foto
                    </button>
                <?php endif; ?>
                <div id="photo-crop-panel" class="crop-panel d-none">
                    <p class="small fw-semibold mb-2">Atur potongan foto</p>
                    <div class="crop-stage">
                        <img id="photo-crop-image" alt="Pratinjau crop foto profil">
                    </div>
                    <div class="crop-tools d-flex justify-content-center gap-2 mt-3">
                        <button type="button" class="btn btn-light" data-crop-action="zoom-out" aria-label="Perkecil foto" title="Perkecil">
                            <i class="bi bi-zoom-out" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-light" data-crop-action="zoom-in" aria-label="Perbesar foto" title="Perbesar">
                            <i class="bi bi-zoom-in" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-light" data-crop-action="rotate-left" aria-label="Putar ke kiri" title="Putar ke kiri">
                            <i class="bi bi-arrow-counterclockwise" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-light" data-crop-action="rotate-right" aria-label="Putar ke kanan" title="Putar ke kanan">
                            <i class="bi bi-arrow-clockwise" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-light" data-crop-action="reset" aria-label="Atur ulang crop" title="Atur ulang">
                            <i class="bi bi-arrow-repeat" aria-hidden="true"></i>
                        </button>
                    </div>
                    <button type="submit" id="save-cropped-photo" class="btn btn-success w-100 rounded-3 mt-3" disabled>
                        <i class="bi bi-check2 me-1" aria-hidden="true"></i>
                        Crop dan simpan
                    </button>
                </div>
                <div id="photo-upload-error" class="small text-danger mt-2" role="alert" aria-live="polite"></div>
                <p class="small text-secondary mt-2 mb-0">JPG, PNG, atau WebP. Maksimal 2 MB.</p>
            </form>
        </section>

        <section class="summary-panel" aria-labelledby="summary-title">
            <h2 id="summary-title" class="h6 fw-bold mb-3">Ringkasan keuangan</h2>
            <p class="summary-label mb-0">Total saldo</p>
            <p class="balance-value">Rp<?= number_format($balance, 0, ',', '.') ?></p>

            <div class="row g-3">
                <div class="col-6 summary-item">
                    <div class="summary-label">Pemasukan</div>
                    <div class="summary-value text-success">Rp<?= number_format($totalIncome, 0, ',', '.') ?></div>
                </div>
                <div class="col-6 summary-item">
                    <div class="summary-label">Pengeluaran</div>
                    <div class="summary-value text-danger">Rp<?= number_format($totalExpense, 0, ',', '.') ?></div>
                </div>
            </div>
        </section>

        <button type="button" class="btn btn-outline-danger w-100 py-2 logout-button"
            data-bs-toggle="modal" data-bs-target="#logoutModal">
            <i class="bi bi-box-arrow-right me-2" aria-hidden="true"></i>
            Logout
        </button>
    </main>

    <?= $this->include('partials/navbar', ['activeMenu' => 'profile']) ?>

    <div class="modal fade" id="editProfileModal" tabindex="-1"
        aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4">
                <form action="<?= site_url('dashboard/profile/update') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-header border-0 pb-0">
                        <h2 class="modal-title h5 fw-bold" id="editProfileModalLabel">Edit profil</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <label for="profile-username" class="form-label">Username</label>
                        <input
                            type="text"
                            class="form-control"
                            id="profile-username"
                            name="username"
                            value="<?= esc(old('username', $displayName), 'attr') ?>"
                            minlength="3"
                            maxlength="30"
                            pattern="[A-Za-z0-9.]+"
                            autocomplete="username"
                            required>
                        <div class="form-text">3–30 karakter; hanya huruf, angka, dan titik.</div>
                        <label for="profile-email" class="form-label mt-3">Email</label>
                        <input
                            type="email"
                            class="form-control"
                            id="profile-email"
                            name="email"
                            value="<?= esc(old('email', $email), 'attr') ?>"
                            maxlength="254"
                            autocomplete="email"
                            required>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="logoutModal" tabindex="-1"
        aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4">
                <div class="modal-body text-center p-4">
                    <div class="fs-1 text-danger mb-2">
                        <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                    </div>
                    <h2 class="h5 fw-bold" id="logoutModalLabel">Logout?</h2>
                    <p class="text-secondary mb-4">Kamu akan keluar dari akun ini.</p>
                    <a href="<?= url_to('logout') ?>" class="btn btn-danger w-100 rounded-3 py-2">Ya, Logout</a>
                    <button type="button" class="btn btn-light w-100 mt-2 rounded-3 py-2"
                        data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <?php if (! empty($photoPath)): ?>
        <div class="modal fade" id="deleteProfilePhotoModal" tabindex="-1"
            aria-labelledby="deleteProfilePhotoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-4">
                    <div class="modal-body text-center p-4">
                        <div class="fs-1 text-danger mb-2">
                            <i class="bi bi-trash3" aria-hidden="true"></i>
                        </div>
                        <h2 class="h5 fw-bold" id="deleteProfilePhotoModalLabel">Hapus foto profil?</h2>
                        <p class="text-secondary mb-4">Foto profil yang dihapus tidak dapat dipulihkan.</p>
                        <form action="<?= site_url('dashboard/profile/photo/delete') ?>" method="post">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-danger w-100 rounded-3 py-2">Ya, Hapus Foto</button>
                            <button type="button" class="btn btn-light w-100 mt-2 rounded-3 py-2"
                                data-bs-dismiss="modal">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.js"></script>
    <script>
        <?php if (session()->getFlashdata('showProfileModal')): ?>
            bootstrap.Modal.getOrCreateInstance(document.getElementById('editProfileModal')).show();
        <?php endif; ?>

        document.addEventListener('DOMContentLoaded', function() {
            const photoInput = document.getElementById('profile-photo');
            const cropPanel = document.getElementById('photo-crop-panel');
            const cropImage = document.getElementById('photo-crop-image');
            const cropForm = photoInput.form;
            const saveButton = document.getElementById('save-cropped-photo');
            const errorMessage = document.getElementById('photo-upload-error');
            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            let cropper = null;
            let imageUrl = null;

            photoInput.addEventListener('change', function() {
                const file = photoInput.files[0];
                errorMessage.textContent = '';

                if (!file) return;

                if (!allowedTypes.includes(file.type) || file.size > 2 * 1024 * 1024) {
                    photoInput.value = '';
                    cropPanel.classList.add('d-none');
                    errorMessage.textContent = 'Pilih gambar JPG, PNG, atau WebP berukuran maksimal 2 MB.';
                    return;
                }

                if (typeof Cropper === 'undefined') {
                    errorMessage.textContent = 'Fitur crop belum dapat dimuat. Periksa koneksi lalu muat ulang halaman.';
                    return;
                }

                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }

                if (imageUrl) URL.revokeObjectURL(imageUrl);
                imageUrl = URL.createObjectURL(file);
                cropPanel.classList.remove('d-none');
                saveButton.disabled = true;
                cropImage.onload = function() {
                    cropper = new Cropper(cropImage, {
                        aspectRatio: 1,
                        viewMode: 1,
                        dragMode: 'move',
                        autoCropArea: 0.9,
                        responsive: true,
                        background: false,
                        ready: function() {
                            saveButton.disabled = false;
                        }
                    });
                };
                cropImage.src = imageUrl;
            });

            document.querySelectorAll('[data-crop-action]').forEach(function(button) {
                button.addEventListener('click', function() {
                    if (!cropper) return;

                    switch (button.dataset.cropAction) {
                        case 'zoom-in':
                            cropper.zoom(0.1);
                            break;
                        case 'zoom-out':
                            cropper.zoom(-0.1);
                            break;
                        case 'rotate-left':
                            cropper.rotate(-90);
                            break;
                        case 'rotate-right':
                            cropper.rotate(90);
                            break;
                        case 'reset':
                            cropper.reset();
                            break;
                    }
                });
            });

            cropForm.addEventListener('submit', function(event) {
                if (!cropper) {
                    event.preventDefault();
                    errorMessage.textContent = 'Pilih foto dan tunggu pratinjau crop siap sebelum menyimpan.';
                    return;
                }

                event.preventDefault();
                saveButton.disabled = true;
                errorMessage.textContent = '';

                const canvas = cropper.getCroppedCanvas({
                    width: 512,
                    height: 512,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high'
                });

                if (!canvas) {
                    saveButton.disabled = false;
                    errorMessage.textContent = 'Foto gagal diproses. Coba pilih foto lain.';
                    return;
                }

                canvas.toBlob(function(blob) {
                    if (!blob) {
                        saveButton.disabled = false;
                        errorMessage.textContent = 'Foto gagal diproses. Coba pilih foto lain.';
                        return;
                    }

                    const croppedFile = new File([blob], 'profile-photo.jpg', {
                        type: 'image/jpeg'
                    });
                    const transfer = new DataTransfer();
                    transfer.items.add(croppedFile);
                    photoInput.files = transfer.files;
                    cropForm.submit();
                }, 'image/jpeg', 0.9);
            });
        });
    </script>
</body>

</html>