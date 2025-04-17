<?php
// filepath: c:\laragon\www\al-syam-mosque\app\controllers\EventController.php

class EventController extends Controller {
    private $eventModel;

    public function __construct() {
        $this->eventModel = $this->model('Event');
    }

    public function index() {
        $data = [
            'title' => 'Kegiatan - ' . APP_NAME,
            'rutin' => $this->eventModel->getRegularEvents(),
            'mendatang' => $this->eventModel->getUpcomingEvents()
        ];
        
        $this->view('events/index', $data);
    }

    public function detail($id) {
        $event = $this->eventModel->getEventById($id);
        
        if(!$event) {
            header('Location: /kegiatan');
            exit;
        }

        $data = [
            'title' => $event['title'] . ' - ' . APP_NAME,
            'event' => $event
        ];

        $this->view('events/detail', $data);
    }
}