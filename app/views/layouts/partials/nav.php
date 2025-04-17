<?php
if (!defined('APP_START')) {
    die('No direct access');
}
?>
<header class="header">
    <div class="header-container">
        <div class="logo-container">
            <img src="/img/logo.png" alt="Masjid Al-Syam" class="logo-image">
            <span class="logo-text">Masjid Al-Syam</span>
        </div>
        
        <nav>
            <ul class="nav-menu" id="navMenu">
                <li><a href="/"><i class="fas fa-home"></i> Beranda</a></li>
                <li><a href="/jadwal"><i class="fas fa-clock"></i> Jadwal Sholat</a></li>
                <li><a href="/kegiatan"><i class="fas fa-calendar"></i> Kegiatan</a></li>
                <li><a href="/donasi"><i class="fas fa-hand-holding-heart"></i> Donasi</a></li>
                <li><a href="/kontak"><i class="fas fa-envelope"></i> Kontak</a></li>
            </ul>
        </nav>

        <div class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </div>
    </div>
</header>