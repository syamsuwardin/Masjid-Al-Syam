<?php
class AdminController extends Controller {
    private $settingModel;
    
    public function __construct() {
        if(!isset($_SESSION['admin'])) {
            header('Location: /admin/login');
            exit;
        }
        $this->settingModel = $this->model('Setting');
    }

    public function index() {
        $data = [
            'title' => 'Dashboard Admin',
            'total_articles' => $this->articleModel->getTotalArticles(),
            'total_donations' => $this->donationModel->getTotalDonations(),
            'total_events' => $this->eventModel->getTotalEvents(),
            'latest_donations' => $this->donationModel->getLatestDonations(5),
            'latest_articles' => $this->articleModel->getLatestArticles(5)
        ];
        
        $this->view('admin/dashboard', $data);
    }
}