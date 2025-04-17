<?php
class Setting {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllSettings() {
        $this->db->query('SELECT * FROM settings');
        return $this->db->resultSet();
    }

    public function getSettingsByGroup($group) {
        $this->db->query('SELECT * FROM settings WHERE setting_group = :group');
        $this->db->bind(':group', $group);
        return $this->db->resultSet();
    }

    public function updateSetting($key, $value) {
        $this->db->query('UPDATE settings SET setting_value = :value WHERE setting_key = :key');
        $this->db->bind(':key', $key);
        $this->db->bind(':value', $value);
        return $this->db->execute();
    }
}