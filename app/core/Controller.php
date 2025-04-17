<?php
class Controller {
    public function view($view, $data = []) {
        // Define APP_START here to ensure it's available
        define('APP_START', true);
        
        // Extract data untuk digunakan di view
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Load view yang diminta
        require_once VIEWS_PATH . '/' . $view . '.php';
        
        // Ambil konten dari buffer dan bersihkan
        $content = ob_get_clean();
        
        // Load template utama dengan konten
        require_once VIEWS_PATH . '/layouts/main.php';
    }

    public function model($model) {
        require_once MODELS_PATH . '/' . $model . '.php';
        return new $model();
    }
}