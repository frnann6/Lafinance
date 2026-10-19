<?php
$currentSegment = service('uri')->getSegment(2);

$activeMenu = match ($currentSegment) {
    'home'         => 'home',
    'transactions' => 'transactions',
    'profile'      => 'profile',
    default        => $activeMenu ?? '',
};
?>

<link rel="stylesheet" href="<?= base_url('assets/css/navbar.css') ?>">

<nav class="bottom-nav">
    <div class="d-flex justify-content-around w-100">
        <a
            href="<?= site_url('dashboard/home') ?>"
            class="nav-item <?= ($activeMenu ?? '') === 'home' ? 'active' : '' ?>">
            <span class="nav-icon">⌂</span>
            Beranda
        </a>

        <a
            href="<?= site_url('dashboard/transactions') ?>"
            class="nav-item <?= ($activeMenu ?? '') === 'transactions' ? 'active' : '' ?>">
            <span class="nav-icon">⇄</span>
            Transaksi
        </a>

        <a
            href="<?= site_url('dashboard/profile') ?>"
            class="nav-item <?= ($activeMenu ?? '') === 'profile' ? 'active' : '' ?>">
            <span class="nav-icon">♙</span>
            Profil
        </a>
    </div>
</nav>