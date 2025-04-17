<?php
if (!defined('APP_START')) {
    die('No direct access');
}
?>
<footer class="footer">
    <div class="container">
        <div class="grid">
            <div class="footer-section contact-info">
                <h3>Masjid Al-Syam</h3>
                <ul>
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        Jalan Masjid No. 123
                    </li>
                    <li>
                        <i class="fas fa-phone"></i>
                        (021) 1234-5678
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        info@masjidalsyam.com
                    </li>
                </ul>
            </div>
            <div class="footer-section quick-links">
                <h3>Menu Utama</h3>
                <ul>
                    <li><a href="/"><span>Beranda</span></a></li>
                    <li><a href="/jadwal"><span>Jadwal Sholat</span></a></li>
                    <li><a href="/kegiatan"><span>Kegiatan</span></a></li>
                    <li><a href="/donasi"><span>Donasi</span></a></li>
                </ul>
            </div>
            <div class="footer-section social-links">
                <h3>Sosial Media</h3>
                <ul>
                    <li>
                        <a href="#" target="_blank" class="facebook">
                            <i class="fab fa-facebook-f"></i>
                            <span>Facebook</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" target="_blank" class="instagram">
                            <i class="fab fa-instagram"></i>
                            <span>Instagram</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" target="_blank" class="youtube">
                            <i class="fab fa-youtube"></i>
                            <span>YouTube</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; <?php echo date('Y'); ?> Masjid Al-Syam. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Move scripts to bottom for better performance -->
<script nonce="<?php echo htmlspecialchars(uniqid()); ?>">
    'use strict';
    document.getElementById('menuToggle')?.addEventListener('click', function() {
        document.getElementById('navMenu')?.classList.toggle('active');
    });
</script>
<script src="/js/main.js" defer></script>
</body>
</html>