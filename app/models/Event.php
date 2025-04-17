<?php

class Event {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getLatestEvents($limit = 3) {
        $this->db->query('SELECT id, title, description, event_date, event_time, 
                         time_desc, location, image, status, type, ustadz, schedule 
                         FROM events 
                         WHERE event_date >= CURDATE() 
                         ORDER BY event_date ASC 
                         LIMIT :limit');
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function getAllEvents() {
        $this->db->query('SELECT * FROM events ORDER BY event_date DESC');
        return $this->db->resultSet();
    }

    public function getRegularEvents() {
        $this->db->query('SELECT id, title, description, event_date, event_time, 
                         location, image, status, type, ustadz, schedule 
                         FROM events 
                         WHERE type = "regular" 
                         AND status = "active" 
                         ORDER BY schedule ASC');
        return $this->db->resultSet();
    }

    public function getUpcomingEvents() {
        $this->db->query('SELECT id, title, description, event_date, event_time, 
                         location, image, status, type, ustadz, schedule 
                         FROM events 
                         WHERE type = "special" 
                         AND event_date >= CURDATE() 
                         AND status = "upcoming" 
                         ORDER BY event_date ASC');
        return $this->db->resultSet();
    }

    public function getEventById($id) {
        $this->db->query('SELECT id, title, description, event_date, event_time, 
                         location, image, status, type, ustadz, schedule 
                         FROM events WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
}