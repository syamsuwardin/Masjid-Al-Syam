<?php
class ArticleController extends Controller {
    private $articleModel;
    
    public function __construct() {
        $this->articleModel = $this->model('Article');
    }

    public function index() {
        try {
            $data = [
                'title' => 'Artikel - ' . APP_NAME,
                'articles' => $this->articleModel->getAllArticles()
            ];
            
            $this->view('articles/index', $data);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $data = [
                'title' => 'Error - ' . APP_NAME,
                'message' => 'Terjadi kesalahan saat memuat artikel.'
            ];
            $this->view('errors/index', $data);
        }
    }

    public function show($slug) {
        $article = $this->articleModel->getArticleBySlug($slug);
        
        if(!$article) {
            header('Location: /artikel');
            exit;
        }

        // Update view count
        $this->articleModel->updateViews($article['id']);

        $data = [
            'title' => $article['title'] . ' - ' . APP_NAME,
            'article' => $article,
            'featured_articles' => $this->articleModel->getFeaturedArticles(3)
        ];
        
        $this->view('articles/show', $data);
    }

    public function category($category) {
        if (!in_array($category, ['berita', 'pengumuman', 'artikel'])) {
            header('Location: /artikel');
            exit;
        }

        $data = [
            'title' => ucfirst($category) . ' - ' . APP_NAME,
            'category' => $category,
            'articles' => $this->articleModel->getAllArticles($category)
        ];
        
        $this->view('articles/category', $data);
    }
}