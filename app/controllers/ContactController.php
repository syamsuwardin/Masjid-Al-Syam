<?php
class ContactController extends Controller {
    private $contactModel;
    
    public function __construct() {
        // Nanti bisa ditambahkan model jika diperlukan
    }
    
    public function index() {
        $data = [
            'title' => 'Kontak - ' . APP_NAME,
            'alamat' => 'Jalan Masjid No. 123, Kota, Provinsi 12345',
            'telepon' => '(021) 1234-5678',
            'email' => 'info@masjidalsyam.com',
            'jam_operasional' => 'Setiap hari 24 jam'
        ];
        
        $this->view('contact/index', $data);
    }

    public function send() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /kontak');
            exit;
        }

        // Sanitize inputs
        $contactData = [
            'nama' => trim(filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING)),
            'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
            'subjek' => trim(filter_input(INPUT_POST, 'subjek', FILTER_SANITIZE_STRING)),
            'pesan' => trim(filter_input(INPUT_POST, 'pesan', FILTER_SANITIZE_STRING))
        ];

        // Validasi
        if (empty($contactData['nama']) || empty($contactData['email']) || 
            empty($contactData['subjek']) || empty($contactData['pesan'])) {
            header('Location: /kontak?error=missing_fields');
            exit;
        }

        if (!filter_var($contactData['email'], FILTER_VALIDATE_EMAIL)) {
            header('Location: /kontak?error=invalid_email');
            exit;
        }

        // Simpan ke session untuk ditampilkan
        $_SESSION['success'] = 'Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.';
        header('Location: /kontak');
        exit;
    }
}