<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?>Login<?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="mb-4">
    <h2>Selamat datang!</h2>
    <p class="mb-0">Masuk untuk mengelola keuanganmu.</p>
</div>

<?php if (session('error') !== null) : ?>
    <div class="alert alert-danger alert-dismissible rounded-3 toast-alert" role="alert">
        <?= esc(session('error')) ?>
        <button type="button" class="btn-close" aria-label="Tutup notifikasi"></button>
    </div>
<?php elseif (session('errors') !== null) : ?>
    <div class="alert alert-danger alert-dismissible rounded-3 toast-alert" role="alert">
        <?php if (is_array(session('errors'))) : ?>
            <?php foreach (session('errors') as $error) : ?>
                <div><?= esc($error) ?></div>
            <?php endforeach ?>
        <?php else : ?>
            <?= esc(session('errors')) ?>
        <?php endif ?>
        <button type="button" class="btn-close" aria-label="Tutup notifikasi"></button>
    </div>
<?php endif ?>

<?php if (session('message') !== null) : ?>
    <div class="alert alert-success alert-dismissible rounded-3 toast-alert" role="alert">
        <?= esc(session('message')) ?>
        <button type="button" class="btn-close" aria-label="Tutup notifikasi"></button>
    </div>
<?php endif ?>

<form action="<?= url_to('login') ?>" method="post">
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
        <label for="password" class="form-label">Kata sandi</label>
        <div class="input-group">
            <input
                type="password"
                class="form-control"
                id="password"
                name="password"
                autocomplete="current-password"
                placeholder="Masukkan kata sandi"
                required>
            <button type="button" class="btn btn-outline-secondary" data-toggle-password="password" aria-label="Lihat kata sandi">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5A3.5 3.5 0 1 0 8 4.5a3.5 3.5 0 0 0 0 7" />
                </svg>
            </button>
        </div>
    </div>

    <!-- <?php if (setting('Auth.sessionConfig')['allowRemembering']) : ?>
        <div class="form-check mb-3">
            <input
                type="checkbox"
                name="remember"
                id="remember"
                class="form-check-input"
                value="1"
                <?= old('remember') ? 'checked' : '' ?>>
            <label class="form-check-label" for="remember">
                <?= lang('Auth.rememberMe') ?>
            </label>
        </div>
    <?php endif ?> -->

    <button type="submit" class="btn btn-success w-100 mt-2">
        Masuk
    </button>

    <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
        <p class="text-center mt-3 mb-0 small">
            <?= lang('Auth.forgotPassword') ?>
            <a href="<?= url_to('magic-link') ?>" class="text-decoration-none fw-semibold">
                <?= lang('Auth.useMagicLink') ?>
            </a>
        </p>
    <?php endif ?>

    <?php if (setting('Auth.allowRegistration')) : ?>
        <div class="text-center mt-4 pt-3 border-top">
            <p class="mb-1 small">Belum punya akun?</p>
            <a href="<?= url_to('register') ?>" class="fw-semibold text-decoration-none">
                Daftar sekarang
            </a>
        </div>
    <?php endif ?>
</form>

<script>
    const eyeOpenIcon = `
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5A3.5 3.5 0 1 0 8 4.5a3.5 3.5 0 0 0 0 7" />
        </svg>
    `;

    const eyeSlashIcon = `
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
            <path d="M13.359 11.238 14.7 12.58l-1.2 1.2-2.106-2.106A9.51 9.51 0 0 1 8 12.5c-4.88 0-7.5-4.5-7.5-4.5a12.4 12.4 0 0 1 4.167-4.743L1.3 2.42l1.2-1.2 11.859 11.858ZM5.6 7.4l2.012 2.012A2.5 2.5 0 0 1 8.588 8.4L5.6 7.4Zm2.2-1.2L9.672 8.9A2.5 2.5 0 0 1 8.9 9.672L7.8 8.6Zm7.1-1.7c-.572-.604-1.256-1.15-2.026-1.615l-1.65 1.65A7.05 7.05 0 0 0 8 4.5C5.8 4.5 4.03 5.827 2.759 6.857L4.09 8.188c.65-.615 1.615-1.188 2.91-1.688a3.5 3.5 0 0 1 4.8 3.266l1.5 1.5a9.5 9.5 0 0 0 2.9-2.83Z" />
        </svg>
    `;

    document.addEventListener('click', function (event) {
        const closeButton = event.target.closest('.toast-alert .btn-close');
        const toggleButton = event.target.closest('[data-toggle-password]');

        if (closeButton) {
            closeButton.closest('.toast-alert').remove();
        }

        if (toggleButton) {
            const input = document.getElementById(toggleButton.getAttribute('data-toggle-password'));

            if (!input) {
                return;
            }

            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            toggleButton.innerHTML = isPassword ? eyeSlashIcon : eyeOpenIcon;
            toggleButton.setAttribute('aria-label', isPassword ? 'Sembunyikan kata sandi' : 'Lihat kata sandi');
        }
    });
</script>

<?= $this->endSection() ?>