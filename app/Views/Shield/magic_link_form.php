
<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?>Magic Link<?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="mb-4">
    <h2>Login tanpa kata sandi</h2>
    <!-- <p class="mb-0">
        Masukkan email akunmu. Jika fitur ini tersedia untuk akunmu,
        Shield akan mengirimkan tautan login melalui email.
    </p> -->
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

<form action="<?= url_to('magic-link') ?>" method="post">
    <?= csrf_field() ?>

    <div class="mb-4">
        <label for="email" class="form-label">Email</label>
        <input
            type="email"
            class="form-control"
            id="email"
            name="email"
            autocomplete="email"
            inputmode="email"
            placeholder="nama@email.com"
            value="<?= esc(old('email', auth()->user()->email ?? null) ?? '') ?>"
            required
        >
    </div>

    <button type="submit" class="btn btn-success w-100">
        Kirim Tautan Login
    </button>
</form>

<div class="text-center mt-4 pt-3 border-top">
    <a
        href="<?= url_to('login') ?>"
        class="fw-semibold text-decoration-none"
    >
        Kembali ke halaman Masuk
    </a>
</div>

<?= $this->endSection() ?>
