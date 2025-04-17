<?php if (!defined('APP_START')) die('No direct access'); ?>

<!-- Prayer Times Header -->
<section class="page-header">
    <div class="container">
        <h1>Jadwal Sholat</h1>
        <p>Jadwal Waktu Sholat untuk Wilayah Jakarta dan Sekitarnya</p>
    </div>
</section>

<!-- Today's Prayer Times -->
<section class="prayer-times">
    <div class="container">
        <h2 class="section-title">Jadwal Sholat Hari Ini</h2>
        
        <div class="prayer-grid">
            <!-- Imsyak -->
            <div class="prayer-card">
                <div class="prayer-icon">
                    <i class="fas fa-moon"></i>
                </div>
                <div class="prayer-info">
                    <h3>Imsyak</h3>
                    <div class="prayer-time"><?= isset($prayer_times['imsak']) ? $prayer_times['imsak'] : '-' ?></div>
                </div>
            </div>

            <!-- Subuh -->
            <div class="prayer-card">
                <div class="prayer-icon">
                    <i class="fas fa-sun"></i>
                </div>
                <div class="prayer-info">
                    <h3>Subuh</h3>
                    <div class="prayer-time"><?= $prayer_times['fajr'] ?></div>
                </div>
            </div>

            <!-- Dzuhur -->
            <div class="prayer-card">
                <div class="prayer-icon">
                    <i class="fas fa-sun"></i>
                </div>
                <div class="prayer-info">
                    <h3>Dzuhur</h3>
                    <div class="prayer-time"><?= $prayer_times['dhuhr'] ?></div>
                </div>
            </div>

            <!-- Ashar -->
            <div class="prayer-card">
                <div class="prayer-icon">
                    <i class="fas fa-sun"></i>
                </div>
                <div class="prayer-info">
                    <h3>Ashar</h3>
                    <div class="prayer-time"><?= $prayer_times['asr'] ?></div>
                </div>
            </div>

            <!-- Maghrib -->
            <div class="prayer-card">
                <div class="prayer-icon">
                    <i class="fas fa-moon"></i>
                </div>
                <div class="prayer-info">
                    <h3>Maghrib</h3>
                    <div class="prayer-time"><?= $prayer_times['maghrib'] ?></div>
                </div>
            </div>

            <!-- Isya -->
            <div class="prayer-card">
                <div class="prayer-icon">
                    <i class="fas fa-moon"></i>
                </div>
                <div class="prayer-info">
                    <h3>Isya</h3>
                    <div class="prayer-time"><?= $prayer_times['isha'] ?></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Weekly Schedule -->
<section class="weekly-schedule">
    <div class="container">
        <h2>Jadwal Mingguan</h2>
        <div class="schedule-table">
            <table>
                <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Imsyak</th>
                        <th>Subuh</th>
                        <th>Dzuhur</th>
                        <th>Ashar</th>
                        <th>Maghrib</th>
                        <th>Isya</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($weekly_prayers as $schedule): ?>
                        <tr>
                            <td><?= htmlspecialchars($schedule['day'] ?? '') ?></td>
                            <td><?= htmlspecialchars($schedule['times']['imsak'] ?? '') ?></td>
                            <td><?= htmlspecialchars($schedule['times']['fajr'] ?? '') ?></td>
                            <td><?= htmlspecialchars($schedule['times']['dhuhr'] ?? '') ?></td>
                            <td><?= htmlspecialchars($schedule['times']['asr'] ?? '') ?></td>
                            <td><?= htmlspecialchars($schedule['times']['maghrib'] ?? '') ?></td>
                            <td><?= htmlspecialchars($schedule['times']['isha'] ?? '') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Monthly Jumat Schedule -->
<section class="monthly-schedule">
    <div class="container">
        <h2>Jadwal Imam & Khatib Jumat</h2>
        <div class="schedule-table">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Imam</th>
                        <th>Khatib</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($jumat_schedules)): ?>
                        <?php foreach($jumat_schedules as $schedule): ?>
                        <tr>
                            <td><?= date('d F Y', strtotime($schedule['date'])) ?></td>
                            <td><?= htmlspecialchars($schedule['imam']) ?></td>
                            <td><?= htmlspecialchars($schedule['khatib']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">Belum ada jadwal tersedia</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>