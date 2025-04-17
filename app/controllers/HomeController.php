<?php

class HomeController extends Controller {
    private $articleModel;
    private $perPage = 6; // Jumlah artikel per halaman

    public function __construct() {
        $this->articleModel = $this->model('Article');
    }

    public function index() {
        try {
             // Get current page dari URL
             $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

             // Validasi page
                if ($page < 1) $page = 1;

            // Hitung total artikel dan total halaman
            $totalArticles = $this->articleModel->getTotalPublishedArticles();
            $totalPages = ceil($totalArticles / $this->perPage);

            // Validasi page tidak melebihi total 
            if ($page > $totalPages) $page = $totalPages;
            $data = [
                'title' => APP_NAME,   
                'featured_articles' => $this->articleModel->getPublishedArticles($page, $this->perPage),
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_articles' => $totalArticles
            ];
            $this->view('home/index', $data);
        } catch (PDOException $e) {
            error_log($e->getMessage());

            $data = [
                'title' => 'Error - ' . APP_NAME,
                'message' => 'Terjadi kesalahan saat memuat data.'
            ];
            $this->view('errors/index', $data);
        }
    }
}