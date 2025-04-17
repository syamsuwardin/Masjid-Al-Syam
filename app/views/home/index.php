<?php if (!defined('APP_START')) die('No direct access'); ?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>Selamat Datang di Masjid Al-Syam</h1>
        <p>Pusat Kegiatan Islam dan Pembinaan Umat</p>
    </div>
</section>

<!-- Articles Section -->
<section class="section articles-section">
    <div class="container">
        <h2>Artikel Terbaru</h2>
        <div class="articles-grid">
            <?php if(!empty($featured_articles)): ?>
                <?php foreach($featured_articles as $article): ?>
                    <div class="article-card">
                        <?php if(isset($article['image'])): ?>
                            <img src="/img/articles/<?= htmlspecialchars($article['image']) ?>" 
                                 alt="<?= htmlspecialchars($article['title']) ?>">
                        <?php endif; ?>
                        
                        <div class="card-body">
                            <span class="category-badge <?= $article['category'] ?>">
                                <?= ucfirst($article['category']) ?>
                            </span>
                            
                            <h3 title="<?= htmlspecialchars($article['title']) ?>">
                                <?php
                                $title = htmlspecialchars($article['title']);
                                $words = explode(' ', $title);
                                if (count($words) > 8) { // Batasi menjadi 8 kata
                                    $shortTitle = implode(' ', array_slice($words, 0, 8)) . '...';
                                } else {
                                    $shortTitle = $title;
                                }
                                echo $shortTitle;
                                ?>
                            </h3>
                            <p><?= substr(strip_tags($article['content']), 0, 150) ?>...</p>
                            
                            <div class="card-footer">
                                <span class="date">
                                    <i class="far fa-calendar"></i>
                                    <?= date('d M Y', strtotime($article['created_at'])) ?>
                                </span>
                                <a href="/artikel/<?= $article['slug'] ?>" class="btn">
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                 <!-- Pagination -->
                 <?php if($total_pages > 1): ?>
                <div class="pagination">
                    <?php if($current_page > 1): ?>
                        <a href="/?page=<?= $current_page - 1 ?>" class="page-link">
                            <i class="fas fa-chevron-left"></i> Sebelumnya
                        </a>
                    <?php endif; ?>

                    <?php for($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="/?page=<?= $i ?>" 
                           class="page-link <?= $i === $current_page ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if($current_page < $total_pages): ?>
                        <a href="/?page=<?= $current_page + 1 ?>" class="page-link">
                            Selanjutnya <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="no-articles">
                    <p>Belum ada artikel yang dipublikasikan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>