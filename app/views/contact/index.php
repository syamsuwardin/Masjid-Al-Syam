<?php if (!defined('APP_START')) die('No direct access'); 
// Generate CSRF token
$csrf_token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
?>

<section class="page-header">
    <div class="container">
        <h1>Hubungi Kami</h1>
        <p>Silakan hubungi kami jika ada pertanyaan atau informasi</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="contact-wrapper grid">
            <!-- Form Kontak -->
            <div class="contact-form card">
                <h2>Kirim Pesan</h2>
                
                <?php if(isset($_GET['error'])): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>
                            <?php
                            switch($_GET['error']) {
                                case 'missing_fields':
                                    echo 'Mohon lengkapi semua field';
                                    break;
                                case 'invalid_email':
                                    echo 'Format email tidak valid';
                                    break;
                                case 'invalid_name':
                                    echo 'Nama hanya boleh menggunakan huruf';
                                    break;
                                case 'invalid_token':
                                    echo 'Token tidak valid. Silakan coba lagi';
                                    break;
                                default:
                                    echo 'Terjadi kesalahan. Silakan coba lagi';
                            }
                            ?>
                        </span>
                    </div>
                <?php endif; ?>

                <form action="/kontak/send" method="POST" id="formKontak">
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
                               value="<?= isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : '' ?>"
                               title="Nama hanya boleh menggunakan huruf">
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required
                               maxlength="255"
                               value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                    </div>

                    <div class="form-group">
                        <label for="subjek">Subjek <span class="required">*</span></label>
                        <input type="text" 
                               id="subjek" 
                               name="subjek" 
                               required
                               maxlength="200"
                               value="<?= isset($_POST['subjek']) ? htmlspecialchars($_POST['subjek']) : '' ?>">
                    </div>

                    <div class="form-group">
                        <label for="pesan">Pesan <span class="required">*</span></label>
                        <textarea id="pesan" 
                                  name="pesan" 
                                  rows="5" 
                                  required
                                  maxlength="1000"><?= isset($_POST['pesan']) ? htmlspecialchars($_POST['pesan']) : '' ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                </form>
            </div>

            <!-- Informasi Kontak -->
            <div class="info-contact">
                <div class="info-card">
                    <h3><i class="fas fa-map-marker-alt"></i> Alamat</h3>
                    <p><?= htmlspecialchars($alamat) ?></p>
                </div>

                <div class="info-card">
                    <h3><i class="fas fa-phone"></i> Telepon</h3>
                    <p><?= htmlspecialchars($telepon) ?></p>
                </div>

                <div class="info-card">
                    <h3><i class="fas fa-envelope"></i> Email</h3>
                    <p><?= htmlspecialchars($email) ?></p>
                </div>

                <div class="info-card">
                    <h3><i class="fas fa-clock"></i> Jam Operasional</h3>
                    <p><?= htmlspecialchars($jam_operasional) ?></p>
                </div>

                <!-- Google Maps -->
                <div class="map-container card">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=..." 
                        width="100%" 
                        height="300" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Client-side validation -->
<script nonce="<?= htmlspecialchars(uniqid()) ?>">
'use strict';

document.getElementById('formKontak').addEventListener('submit', function(e) {
    const nama = document.getElementById('nama').value.trim();
    const email = document.getElementById('email').value.trim();
    
    // Validate name
    if (!/^[A-Za-z\s]+$/.test(nama)) {
        e.preventDefault();
        alert('Nama hanya boleh menggunakan huruf');
        return false;
    }
    
    // Validate email
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        e.preventDefault();
        alert('Format email tidak valid');
        return false;
    }
});

// Prevent XSS in name field
document.getElementById('nama').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^A-Za-z\s]/g, '');
});
</script>