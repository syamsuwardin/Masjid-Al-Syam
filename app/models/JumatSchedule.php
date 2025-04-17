<?php

class JumatSchedule {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getUpcomingSchedules() {
        $this->db->query('SELECT * FROM jumat_schedules 
                         WHERE date >= CURDATE() 
                         ORDER BY date ASC 
                         LIMIT 4');
        return $this->db->resultSet();
    }
}