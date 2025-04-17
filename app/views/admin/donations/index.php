<?php if (!defined('APP_START')) die('No direct access'); ?>

<div class="admin-content">
    <div class="content-header">
        <h1>Kelola Donasi</h1>
    </div>

    <div class="stats-cards">
        <div class="stat-card pending">
            <h3>Donasi Pending</h3>
            <div class="amount">Rp <?= number_format($total_pending, 0, ',', '.') ?></div>
        </div>
        <div class="stat-card confirmed">
            <h3>Donasi Terkonfirmasi</h3>
            <div class="amount">Rp <?= number_format($total_confirmed, 0, ',', '.') ?></div>
        </div>
    </div>

    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <div class="data-table">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Ref</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jumlah</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($donations as $donation): ?>
                <tr>
                    <td><?= date('d/m/Y H:i', strtotime($donation['created_at'])) ?></td>
                    <td><?= htmlspecialchars($donation['ref']) ?></td>
                    <td><?= $donation['is_hidden'] ? 'Hamba Allah' : htmlspecialchars($donation['nama']) ?></td>
                    <td><?= htmlspecialchars($donation['email']) ?></td>
                    <td>Rp <?= number_format($donation['jumlah'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($donation['metode']) ?></td>
                    <td>
                        <span class="status-badge <?= $donation['status'] ?>">
                            <?= ucfirst($donation['status']) ?>
                        </span>
                    </td>
                    <td>
                        <?php if($donation['status'] == 'pending'): ?>
                            <a href="/admin/donations/confirm/<?= $donation['id'] ?>" 
                               class="btn btn-success btn-sm"
                               onclick="return confirm('Konfirmasi donasi ini?')">
                                Konfirmasi
                            </a>
                            <a href="/admin/donations/cancel/<?= $donation['id'] ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Batalkan donasi ini?')">
                                Batalkan
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>