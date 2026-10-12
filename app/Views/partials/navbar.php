<nav class="bottom-nav">
    <div class="d-flex justify-content-around w-100">
        <a
            href="<?= site_url('dashboard') ?>"
            class="nav-item <?= ($activeMenu ?? '') === 'home' ? 'active' : '' ?>">
            <span class="nav-icon">⌂</span>
            Beranda
        </a>

        <a
            href="<?= site_url('transactions') ?>"
            class="nav-item <?= ($activeMenu ?? '') === 'transactions' ? 'active' : '' ?>">
            <span class="nav-icon">⇄</span>
            Transaksi
        </a>

        <a
            href="<?= site_url('profile') ?>"
            class="nav-item <?= ($activeMenu ?? '') === 'profile' ? 'active' : '' ?>">
            <span class="nav-icon">♙</span>
            Profil
        </a>
    </div>
</nav>