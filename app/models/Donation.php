<?php
// filepath: c:\laragon\www\al-syam-mosque\app\models\Donation.php

class Donation {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getRekening() {
        return [
            [
                'bank' => 'Bank Syariah Indonesia',
                'nomor' => '7140242141',
                'atas_nama' => 'Yayasan Al-Syam',
                'icon' => 'bsi.png'
            ],
            [
                'bank' => 'Bank Mandiri Syariah',
                'nomor' => '7089123456',
                'atas_nama' => 'Yayasan Al-Syam',
                'icon' => 'bsm.png'
            ],
            [
                'bank' => 'Bank Aceh Syariah',
                'nomor' => '1234567890',
                'atas_nama' => 'Yayasan Al-Syam',
                'icon' => 'bpd.png'
            ],
            [
                'bank' => 'Bank BCA Syariah',
                'nomor' => '9876543210',
                'atas_nama' => 'Yayasan Al-Syam',
                'icon' => 'bcas.png'
            ]
        ];
    }

    public function getTotalDonations() {
        $this->db->query('SELECT SUM(jumlah) as total FROM donations WHERE status = "confirmed"');
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }

    public function getLatestDonations($limit = 5) {
        $this->db->query('SELECT nama, jumlah, pesan, created_at 
                         FROM donations 
                         WHERE status = "confirmed" 
                         AND is_hidden = 0
                         ORDER BY created_at DESC 
                         LIMIT :limit');
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function addDonation($data) {
        $this->db->query('INSERT INTO donations 
                        (nama, email, jumlah, metode, pesan, is_hidden, status) 
                        VALUES 
                        (:nama, :email, :jumlah, :metode, :pesan, :is_hidden, :status)');
        
        $this->db->bind(':nama', $data['nama']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':jumlah', $data['jumlah']);
        $this->db->bind(':metode', $data['metode']);
        $this->db->bind(':pesan', $data['pesan']);
        $this->db->bind(':is_hidden', $data['is_hidden']);
        $this->db->bind(':status', $data['status']);

        return $this->db->execute();
    }

    public function getAllDonations() {
        $this->db->query('SELECT * FROM donations ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function getTotalByStatus($status) {
        $this->db->query('SELECT SUM(jumlah) as total FROM donations WHERE status = :status');
        $this->db->bind(':status', $status);
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }

    public function updateStatus($id, $status) {
        $this->db->query('UPDATE donations SET 
                         status = :status,
                         updated_at = NOW()
                         WHERE id = :id');
        
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }

    public function getDonationById($id) {
        $this->db->query('SELECT * FROM donations WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
}
?>