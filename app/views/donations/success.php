<?php if (!defined('APP_START')) die('No direct access'); ?>

<section class="page-header">
    <div class="container">
        <h1>Donasi Berhasil</h1>
        <p>Terima kasih atas donasi Anda</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="success-message card">
            <div class="icon-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2>Alhamdulillah, Donasi Berhasil Diproses</h2>
            <div class="donation-details">
                <p>Nomor Referensi: <strong><?= htmlspecialchars($donation['ref']) ?></strong></p>
                <p>Nama: <strong><?= htmlspecialchars($donation['nama']) ?></strong></p>
                <p>Jumlah: <strong>Rp <?= number_format($donation['jumlah'], 0, ',', '.') ?></strong></p>
            </div>
            
            <div class="bank-info">
                <h3>Silakan Transfer ke Rekening:</h3>
                <?php foreach($rekening as $rek): ?>
                    <?php if($rek['bank'] === $donation['metode']): ?>
                        <p class="bank-number"><?= htmlspecialchars($rek['bank']) ?>: <?= htmlspecialchars($rek['nomor']) ?></p>
                        <p class="bank-name">a.n <?= htmlspecialchars($rek['atas_nama']) ?></p>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            
            <p class="note">Konfirmasi pembayaran akan dikirim melalui email.</p>

            <div class="action-buttons">
                <a href="/donasi" class="btn btn-outline">Kembali ke Halaman Donasi</a>
                <a href="/" class="btn btn-primary">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</section>