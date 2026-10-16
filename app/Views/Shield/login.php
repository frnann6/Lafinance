<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?>Masuk<?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="mb-4">
    <h2>Selamat datang!</h2>
    <p class="mb-0">Masuk untuk mengelola keuanganmu.</p>
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

<?php if (session('message') !== null) : ?>
    <div class="alert alert-success rounded-3" role="alert">
        <?= esc(session('message')) ?>
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
        <input
            type="password"
            class="form-control"
            id="password"
            name="password"
            autocomplete="current-password"
            placeholder="Masukkan kata sandi"
            required>
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
            <a href="<?= url_to('magic-link') ?>">
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

<?= $this->endSection() ?>