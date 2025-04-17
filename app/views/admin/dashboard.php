<?php if (!defined('APP_START')) die('No direct access'); ?>

<div class="admin-dashboard">
    <div class="stats-cards">
        <div class="stat-card">
            <h3>Total Artikel</h3>
            <div class="stat-value"><?= $total_articles ?></div>
        </div>
        <div class="stat-card">
            <h3>Total Donasi</h3>
            <div class="stat-value">Rp <?= number_format($total_donations, 0, ',', '.') ?></div>
        </div>
        <div class="stat-card">
            <h3>Total Kegiatan</h3>
            <div class="stat-value"><?= $total_events ?></div>
        </div>
    </div>

    <div class="dashboard-grid">
        <!-- Latest Donations -->
        <div class="dashboard-card">
            <h3>Donasi Terbaru</h3>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($latest_donations as $donation): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($donation['created_at'])) ?></td>
                                <td><?= $donation['is_hidden'] ? 'Hamba Allah' : htmlspecialchars($donation['nama']) ?></td>
                                <td>Rp <?= number_format($donation['jumlah'], 0, ',', '.') ?></td>
                                <td><span class="status-badge <?= $donation['status'] ?>"><?= ucfirst($donation['status']) ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Latest Articles -->
        <div class="dashboard-card">
            <h3>Artikel Terbaru</h3>
            <div class="article-list">
                <?php foreach($latest_articles as $article): ?>
                    <div class="article-item">
                        <h4><?= htmlspecialchars($article['title']) ?></h4>
                        <div class="article-meta">
                            <span class="category"><?= ucfirst($article['category']) ?></span>
                            <span class="date"><?= date('d/m/Y', strtotime($article['created_at'])) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>