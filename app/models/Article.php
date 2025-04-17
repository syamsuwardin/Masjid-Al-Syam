<?php

class Article {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getLatestArticles($limit = 3) {
        $this->db->query('SELECT * FROM articles ORDER BY created_at DESC LIMIT :limit');
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function getAllArticles($category = null, $limit = null) {
        $sql = 'SELECT * FROM articles WHERE status = "published"';
        
        if ($category) {
            $sql .= ' AND category = :category';
        }
        
        $sql .= ' ORDER BY created_at DESC';
        
        if ($limit) {
            $sql .= ' LIMIT :limit';
        }

        $this->db->query($sql);

        if ($category) {
            $this->db->bind(':category', $category);
        }
        if ($limit) {
            $this->db->bind(':limit', $limit);
        }

        return $this->db->resultSet();
    }

    public function getFeaturedArticles($limit = 6) {
        try {
            // Tambahkan data contoh untuk testing
            $this->db->query("INSERT INTO articles (title, slug, content, category, status, created_at) VALUES 
                ('Artikel 1', 'artikel-1', 'Konten artikel 1', 'berita', 'published', NOW()),
                ('Artikel 2', 'artikel-2', 'Konten artikel 2', 'pengumuman', 'published', NOW()),
                ('Artikel 3', 'artikel-3', 'Konten artikel 3', 'artikel', 'published', NOW()),
                ('Artikel 4', 'artikel-4', 'Konten artikel 4', 'berita', 'published', NOW()),
                ('Artikel 5', 'artikel-5', 'Konten artikel 5', 'pengumuman', 'published', NOW()),
                ('Artikel 6', 'artikel-6', 'Konten artikel 6', 'artikel', 'published', NOW())
            ");

            // Ambil 6 artikel terbaru
            $this->db->query('SELECT * FROM articles 
                             WHERE status = "published" 
                             ORDER BY created_at DESC 
                             LIMIT :limit');
            
            $this->db->bind(':limit', $limit);
            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getArticleBySlug($slug) {
        $this->db->query('SELECT * FROM articles WHERE slug = :slug AND status = "published"');
        $this->db->bind(':slug', $slug);
        return $this->db->single();
    }

    public function getArticlesByCategory($category, $limit = 6) {
        $this->db->query('SELECT * FROM articles WHERE category = :category AND status = "published" ORDER BY created_at DESC LIMIT :limit');
        $this->db->bind(':category', $category);
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function updateViews($id) {
        $this->db->query('UPDATE articles SET views = views + 1 WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function createSlug($title) {
        // Transliterate non-ASCII characters
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $title);
        // Convert to lowercase
        $slug = strtolower($slug);
        // Replace non-alphanumeric characters with hyphen
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        // Remove multiple consecutive hyphens
        $slug = preg_replace('/-+/', '-', $slug);
        // Remove leading and trailing hyphens
        $slug = trim($slug, '-');
        return $slug;
    }

    public function getTotalArticles() {
        $this->db->query('SELECT COUNT(*) as total FROM articles WHERE status = "published"');
        $result = $this->db->single();
        return $result['total'];
    }

    public function getTotalPublishedArticles() {
        $this->db->query('SELECT COUNT(*) as total FROM articles WHERE status = "published"');
        $result = $this->db->single();
        return $result['total'];
    }

    public function getPublishedArticles($page = 1, $perPage = 6) {
        $offset = ($page - 1) * $perPage;
        
        $this->db->query('SELECT * FROM articles 
                         WHERE status = "published" 
                         ORDER BY created_at DESC 
                         LIMIT :limit OFFSET :offset');
                         
        $this->db->bind(':limit', $perPage);
        $this->db->bind(':offset', $offset);
        
        return $this->db->resultSet();
    }
}