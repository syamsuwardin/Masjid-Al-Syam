<?php

class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];
    protected $routes = [
        'artikel' => 'ArticleController',
        'donasi' => 'DonationController',
        'kegiatan' => 'EventController',
        'jadwal' => 'JadwalController',
        'kontak' => 'ContactController',
        '' => 'HomeController'
    ];

    public function __construct() {
        $this->parseUrl();
        $this->loadController();
        $this->callMethod();
    }

    protected function parseUrl() {
        if (isset($_GET['url'])) {
            $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
            
            // Map URLs to controllers
            $routes = [
                'donasi' => 'DonationController',
                'kegiatan' => 'EventController',
                'jadwal' => 'JadwalController',
                'kontak' => 'ContactController'  // Tambahkan ini
            ];

            if (isset($routes[$url[0]])) {
                $this->controller = $routes[$url[0]];
                array_shift($url);
            }

            if (isset($url[0])) {
                if (method_exists($this->controller, $url[0])) {
                    $this->method = array_shift($url);
                }
            }

            $this->params = $url ? array_values($url) : [];
        }
    }

    protected function loadController() {
        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;
    }

    protected function callMethod() {
        if (method_exists($this->controller, $this->method)) {
            call_user_func_array([$this->controller, $this->method], $this->params);
        } else {
            // Handle method not found
        }
    }
}