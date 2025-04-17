<?php if (!defined('APP_START')) die('No direct access'); ?>

<section class="page-header">
    <div class="container">
        <h1>Artikel & Berita</h1>
        <p>Informasi terkini seputar Masjid Al-Syam</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <!-- Category Filter -->
        <div class="category-filter">
            <a href="/artikel" class="btn <?= !isset($category) ? 'active' : '' ?>">Semua</a>
            <a href="/artikel/category/berita" class="btn <?= isset($category) && $category === 'berita' ? 'active' : '' ?>">Berita</a>
            <a href="/artikel/category/pengumuman" class="btn <?= isset($category) && $category === 'pengumuman' ? 'active' : '' ?>">Pengumuman</a>
            <a href="/artikel/category/artikel" class="btn <?= isset($category) && $category === 'artikel' ? 'active' : '' ?>">Artikel</a>
        </div>

        <div class="articles-grid grid">
            <?php foreach($articles as $article): ?>
                <article class="article-card">
                    <?php if($article['image']): ?>
                        <img src="/img/articles/<?= htmlspecialchars($article['image']) ?>" 
                             alt="<?= htmlspecialchars($article['title']) ?>">
                    <?php endif; ?>
                    
                    <div class="article-content">
                        <span class="category-badge <?= $article['category'] ?>">
                            <?= ucfirst($article['category']) ?>
                        </span>
                        <?php if($article['featured']): ?>
                            <span class="featured-badge">
                                <i class="fas fa-star"></i> Featured
                            </span>
                        <?php endif; ?>
                        <h3><?= htmlspecialchars($article['title']) ?></h3>
                        <p><?= substr(strip_tags($article['content']), 0, 150) ?>...</p>
                        <div class="article-meta">
                            <span class="views">
                                <i class="far fa-eye"></i> <?= number_format($article['views']) ?> views
                            </span>
                            <span class="date">
                                <i class="far fa-calendar"></i>
                                <?= date('d M Y', strtotime($article['created_at'])) ?>
                            </span>
                        </div>
                        <a href="/artikel/<?= $article['slug'] ?>" class="btn btn-primary">
                            Baca Selengkapnya
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>