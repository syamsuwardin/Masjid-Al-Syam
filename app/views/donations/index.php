<?php 
if (!defined('APP_START')) die('No direct access');
// Generate CSRF token
$csrf_token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
?>

<section class="page-header">
    <div class="container">
        <h1>Donasi</h1>
        <p>Mari Berkontribusi untuk Pembangunan dan Operasional Masjid Al-Syam</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="donation-wrapper grid">
            <!-- Form Donasi -->
            <div class="donation-form card">
                <h2>Form Donasi</h2>
                
                <?php if(isset($_GET['error'])): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>
                            <?php
                            switch($_GET['error']) {
                                case 'missing_fields':
                                    echo 'Mohon lengkapi semua field yang wajib diisi';
                                    break;
                                case 'invalid_email':
                                    echo 'Format email tidak valid';
                                    break;
                                case 'invalid_name':
                                    echo 'Nama hanya boleh menggunakan huruf';
                                    break;
                                case 'min_amount':
                                    echo 'Minimal donasi Rp 10.000';
                                    break;
                                case 'invalid_token':
                                    echo 'Token tidak valid. Silakan coba lagi';
                                    break;
                                case 'system':
                                    echo 'Terjadi kesalahan sistem. Silakan coba lagi nanti';
                                    break;
                                default:
                                    echo 'Terjadi kesalahan. Silakan coba lagi';
                            }
                            ?>
                        </span>
                    </div>
                <?php endif; ?>

                <form action="/donasi/process" method="POST" id="formDonasi">
                    <!-- Add CSRF token -->
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

                    <div class="form-group">
                        <label for="nama">Nama <span class="required">*</span></label>
                        <input type="text" 
                               id="nama" 
                               name="nama" 
                               required 
                               pattern="[A-Za-z\s]+"
                               maxlength="100"
                               onkeypress="return /[A-Za-z\s]/.test(event.key)"
                               title="Nama hanya boleh menggunakan huruf"
                               value="<?= isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : '' ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required
                               maxlength="255"
                               value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                        <small>Digunakan untuk konfirmasi dan laporan donasi</small>
                    </div>

                    <div class="form-group">
                        <label for="jumlah">Jumlah Donasi <span class="required">*</span></label>
                        <div class="input-group">
                            <span class="prefix">Rp</span>
                            <input type="text" 
                                   id="jumlah" 
                                   name="jumlah" 
                                   required 
                                   inputmode="numeric"
                                   onkeyup="formatRupiah(this)"
                                   placeholder="1.000.000"
                                   title="Masukkan jumlah donasi">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Metode Pembayaran <span class="required">*</span></label>
                        <div class="payment-methods">
                            <?php foreach($rekening as $rek): ?>
                            <div class="payment-method">
                                <input type="radio" id="<?= strtolower($rek['bank']) ?>" 
                                       name="metode" value="<?= $rek['bank'] ?>" required>
                                <label for="<?= strtolower($rek['bank']) ?>">
                                    <?php if(isset($rek['icon'])): ?>
                                        <img src="/img/banks/<?= $rek['icon'] ?>" alt="<?= $rek['bank'] ?>">
                                    <?php endif; ?>
                                    <?= $rek['bank'] ?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pesan">Pesan/Doa</label>
                        <textarea id="pesan" name="pesan" rows="3"></textarea>
                    </div>

                    <div class="form-group checkbox">
                        <input type="checkbox" id="sembunyikan_nama" name="sembunyikan_nama">
                        <label for="sembunyikan_nama">Sembunyikan nama saya (Hamba Allah)</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Lanjutkan Donasi</button>
                </form>
            </div>

            <!-- Informasi Donasi -->
            <div class="donation-info card">
                <div class="total-donations">
                    <h2>Total Donasi Terkumpul</h2>
                    <div class="amount">
                        Rp <?= number_format((float)$total_donasi, 0, ',', '.') ?>
                    </div>
                </div>

                <div class="bank-accounts">
                    <h3>Rekening Donasi</h3>
                    <?php foreach($rekening as $rek): ?>
                    <div class="bank-account">
                        <h4><?= htmlspecialchars($rek['bank']) ?></h4>
                        <div class="account-number"><?= htmlspecialchars($rek['nomor']) ?></div>
                        <div class="account-name">a.n <?= htmlspecialchars($rek['atas_nama']) ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?php if(!empty($donasi_terbaru)): ?>
                <div class="latest-donations">
                    <h3>Donasi Terbaru</h3>
                    <div class="donation-list">
                        <?php foreach($donasi_terbaru as $donasi): ?>
                        <div class="donation-item">
                            <div class="donation-amount">
                                Rp <?= number_format((float)$donasi['jumlah'], 0, ',', '.') ?>
                            </div>
                            <div class="donation-name">
                                <?= htmlspecialchars($donasi['nama']) ?>
                            </div>
                            <?php if(!empty($donasi['pesan'])): ?>
                            <div class="donation-message">
                                "<?= htmlspecialchars($donasi['pesan']) ?>"
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Update JavaScript with Content Security Policy -->
<script nonce="<?= htmlspecialchars(uniqid()) ?>">
'use strict';

function formatRupiah(input) {
    // Sanitize input - hanya ambil angka
    let number = input.value.replace(/[^\d]/g, '');
    
    // Format angka dengan titik
    let formatted = new Intl.NumberFormat('id-ID').format(number);
    
    // Update nilai input
    input.value = formatted;
}

// Validasi form
document.getElementById('formDonasi').addEventListener('submit', function(e) {
    let jumlah = document.getElementById('jumlah').value.trim();
    
    // Bersihkan format angka
    let cleanAmount = jumlah.replace(/\./g, '');
    
    // Validasi jumlah minimal
    if (parseInt(cleanAmount) < 10000) {
        e.preventDefault();
        alert('Minimal donasi Rp 10.000');
        return false;
    }
    
    // Set nilai bersih sebelum submit
    document.getElementById('jumlah').value = cleanAmount;
});

// Hanya terima input angka
document.getElementById('jumlah').addEventListener('keypress', function(e) {
    if (!/^\d$/.test(e.key)) {
        e.preventDefault();
    }
});
</script>