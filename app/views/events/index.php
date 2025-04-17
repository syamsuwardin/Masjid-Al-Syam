<?php if (!defined('APP_START')) die('No direct access'); ?>

<section class="page-header">
    <div class="container">
        <h1>Kegiatan Masjid</h1>
        <p>Jadwal dan Informasi Kegiatan di Masjid Al-Syam</p>
    </div>
</section>

<!-- Kegiatan Rutin -->
<section class="section bg-light">
    <div class="container">
        <h2>Kegiatan Rutin</h2>
        <div class="grid">
            <?php foreach($rutin as $event): ?>
            <div class="card event-card">
                <?php if(isset($event['image'])): ?>
                <div class="card-image">
                    <img src="/img/events/<?= htmlspecialchars($event['image']) ?>" 
                         alt="<?= htmlspecialchars($event['title']) ?>">
                </div>
                <?php endif; ?>
                <div class="card-body">
                    <h3><?= htmlspecialchars($event['title']) ?></h3>
                    <p class="event-schedule">
                        <i class="fas fa-calendar"></i> 
                        <?= htmlspecialchars($event['schedule'] ?? '') ?><br>
                        <i class="fas fa-clock"></i> 
                        <?= isset($event['time_desc']) ? htmlspecialchars($event['time_desc']) : date('H:i', strtotime($event['event_time'])) ?><br>
                        <?php if(isset($event['ustadz'])): ?>
                            <i class="fas fa-user"></i> <?= htmlspecialchars($event['ustadz']) ?>
                        <?php endif; ?>
                    </p>
                    <p class="event-description"><?= htmlspecialchars($event['description']) ?></p>
                    <a href="/kegiatan/detail/<?= $event['id'] ?>" class="btn">Selengkapnya</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Kegiatan Mendatang -->
<section class="section">
    <div class="container">
        <h2>Kegiatan Mendatang</h2>
        <div class="grid">
            <?php foreach($mendatang as $event): ?>
            <div class="card event-card">
                <?php if(isset($event['image'])): ?>
                <div class="card-image">
                    <img src="/img/events/<?= htmlspecialchars($event['image']) ?>" 
                         alt="<?= htmlspecialchars($event['title']) ?>">
                </div>
                <?php endif; ?>
                <div class="card-body">
                    <h3><?= htmlspecialchars($event['title']) ?></h3>
                    <p class="event-schedule">
                        <i class="fas fa-calendar"></i> 
                        <?= date('d F Y', strtotime($event['event_date'])) ?><br>
                        <i class="fas fa-clock"></i> 
                        <?= isset($event['time_desc']) ? htmlspecialchars($event['time_desc']) : date('H:i', strtotime($event['event_time'])) ?>
                        <br>
                        <?php if(isset($event['ustadz'])): ?>
                        <i class="fas fa-user"></i> <?= htmlspecialchars($event['ustadz']) ?>
                        <?php endif; ?>
                    </p>
                    <p class="event-description"><?= htmlspecialchars($event['description']) ?></p>
                    <a href="/kegiatan/detail/<?= $event['id'] ?>" class="btn">Selengkapnya</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>