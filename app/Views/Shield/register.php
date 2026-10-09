<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?>Buat Akun<?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="mb-4">
    <h2>Buat akun Lafinance</h2>
    <p class="mb-0">Mulai atur keuanganmu dengan lebih mudah.</p>
</div>

<?php if (session('error') !== null) : ?>
    <div class="alert alert-danger rounded-3" role="alert">
        <?= esc(session('error')) ?>
    </div>
<?php elseif (session('errors') !== null) : ?>
    <div class="alert alert-danger rounded-3" role="alert">
        <?php if (is_array(session('errors'))) : ?>
            <?php foreach (session('errors') as $error) : ?>
                <div><?= esc($error) ?></div>
            <?php endforeach ?>
        <?php else : ?>
            <?= esc(session('errors')) ?>
        <?php endif ?>
    </div>
<?php endif ?>

<form action="<?= url_to('register') ?>" method="post">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input
            type="email"
            class="form-control"
            id="email"
            name="email"
            inputmode="email"
            autocomplete="email"
            placeholder="nama@email.com"
            value="<?= esc(old('email') ?? '') ?>"
            required>
    </div>

    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input
            type="text"
            class="form-control"
            id="username"
            name="username"
            autocomplete="username"
            placeholder="Buat username"
            value="<?= esc(old('username') ?? '') ?>"
            required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Kata sandi</label>
        <div class="input-group">
            <input
                type="password"
                class="form-control"
                id="password"
                name="password"
                autocomplete="new-password"
                placeholder="Buat kata sandi"
                required>
            <button type="button" class="btn btn-outline-secondary" data-toggle-password="password" aria-label="Lihat kata sandi">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5A3.5 3.5 0 1 0 8 4.5a3.5 3.5 0 0 0 0 7"/>
                </svg>
            </button>
        </div>
    </div>

    <div class="mb-4">
        <label for="password_confirm" class="form-label">
            Konfirmasi kata sandi
        </label>
        <div class="input-group">
            <input
                type="password"
                class="form-control"
                id="password_confirm"
                name="password_confirm"
                autocomplete="new-password"
                placeholder="Ulangi kata sandi"
                required>
            <button type="button" class="btn btn-outline-secondary" data-toggle-password="password_confirm" aria-label="Lihat konfirmasi kata sandi">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5A3.5 3.5 0 1 0 8 4.5a3.5 3.5 0 0 0 0 7"/>
                </svg>
            </button>
        </div>
    </div>

    <button type="submit" class="btn btn-success w-100">
        Buat Akun
    </button>

    <div class="text-center mt-4 pt-3 border-top">
        <p class="mb-1 small">Sudah punya akun?</p>
        <a
            href="<?= url_to('login') ?>"
            class="fw-semibold text-decoration-none">
            Masuk ke Lafinance
        </a>
    </div>
</form>

<script>
    const eyeOpenIcon = `
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5A3.5 3.5 0 1 0 8 4.5a3.5 3.5 0 0 0 0 7"/>
        </svg>
    `;

    const eyeSlashIcon = `
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
            <path d="M13.359 11.238 14.7 12.58l-1.2 1.2-2.106-2.106A9.51 9.51 0 0 1 8 12.5c-4.88 0-7.5-4.5-7.5-4.5a12.4 12.4 0 0 1 4.167-4.743L1.3 2.42l1.2-1.2 11.859 11.858ZM5.6 7.4l2.012 2.012A2.5 2.5 0 0 1 8.588 8.4L5.6 7.4Zm2.2-1.2L9.672 8.9A2.5 2.5 0 0 1 8.9 9.672L7.8 8.6Zm7.1-1.7c-.572-.604-1.256-1.15-2.026-1.615l-1.65 1.65A7.05 7.05 0 0 0 8 4.5C5.8 4.5 4.03 5.827 2.759 6.857L4.09 8.188c.65-.615 1.615-1.188 2.91-1.688a3.5 3.5 0 0 1 4.8 3.266l1.5 1.5a9.5 9.5 0 0 0 2.9-2.83Z"/>
        </svg>
    `;

    document.addEventListener('click', function (event) {
        const toggleButton = event.target.closest('[data-toggle-password]');
        if (!toggleButton) {
            return;
        }

        const targetId = toggleButton.getAttribute('data-toggle-password');
        const input = document.getElementById(targetId);

        if (!input) {
            return;
        }

        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        toggleButton.innerHTML = isPassword ? eyeSlashIcon : eyeOpenIcon;
        toggleButton.setAttribute('aria-label', isPassword ? 'Sembunyikan kata sandi' : 'Lihat kata sandi');
    });
</script>

<?= $this->endSection() ?>