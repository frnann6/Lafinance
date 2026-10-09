<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?>Periksa Email<?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="text-center">
    <div
        class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4"
        style="width: 76px; height: 76px; background: #dcfce7; color: #166534;"
        aria-hidden="true">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            width="36"
            height="36"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.8"
            stroke-linecap="round"
            stroke-linejoin="round">
            <rect x="3" y="5" width="18" height="14" rx="2"></rect>
            <path d="m3 7 9 6 9-6"></path>
        </svg>
    </div>

    <h2 class="mb-3">Periksa email kamu</h2>

    <p class="mb-4">
        Jika alamat email tersebut memenuhi persyaratan login,
        kami akan mengirimkan tautan untuk masuk ke akun DuitKu.
    </p>

    <div
        class="text-start rounded-3 p-3 mb-4"
        style="background: #f0fdf4; border: 1px solid #dcfce7;">
        <p class="mb-2 fw-semibold" style="color: #166534;">
            Langkah selanjutnya
        </p>

        <ol class="mb-0 ps-3 small">
            <li class="mb-2">Buka kotak masuk email kamu.</li>
            <li class="mb-2">Periksa folder Spam jika email belum terlihat.</li>
            <li>Klik tautan login yang dikirimkan untuk melanjutkan.</li>
        </ol>
    </div>

    <p class="small text-secondary mb-4">
        <?= lang('Auth.magicLinkDetails', [
            setting('Auth.magicLinkLifetime') / 60
        ]) ?>
    </p>

    <a href="<?= url_to('login') ?>" class="btn btn-success w-100">
        Kembali ke halaman Masuk
    </a>
</div>

<?= $this->endSection() ?>