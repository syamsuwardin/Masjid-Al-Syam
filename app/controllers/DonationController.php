<?php
// filepath: c:\laragon\www\al-syam-mosque\app\controllers\DonationController.php

class DonationController extends Controller {
    private $donationModel;

    public function __construct() {
        $this->donationModel = $this->model('Donation');
    }

    public function index() {
        $data = [
            'title' => 'Donasi - ' . APP_NAME,
            'rekening' => $this->donationModel->getRekening(),
            'total_donasi' => $this->donationModel->getTotalDonations(),
            'donasi_terbaru' => $this->donationModel->getLatestDonations(5)
        ];
        
        $this->view('donations/index', $data);
    }

    public function process() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /donasi');
            exit;
        }

        // Sanitize and validate inputs
        $donationData = [
            'nama' => trim(filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING)),
            'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
            'jumlah' => filter_var(
                preg_replace('/[^\d]/', '', $_POST['jumlah']), 
                FILTER_VALIDATE_INT
            ),
            'metode' => trim(filter_input(INPUT_POST, 'metode', FILTER_SANITIZE_STRING)),
            'pesan' => trim(filter_input(INPUT_POST, 'pesan', FILTER_SANITIZE_STRING)),
            'is_hidden' => isset($_POST['sembunyikan_nama']) ? 1 : 0,
            'status' => 'pending',
            'ref' => uniqid()
        ];

        try {
            if ($this->donationModel->addDonation($donationData)) {
                // Simpan ke session untuk ditampilkan di halaman sukses
                $_SESSION['donation_data'] = $donationData;
                
                // Redirect dengan path absolut
                $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
                header("Location: $baseUrl/donasi/success");
                exit;
            }
        } catch (Exception $e) {
            header('Location: /donasi?error=system');
            exit;
        }
    }

    public function success() {
        // Cek data donasi di session
        if (!isset($_SESSION['donation_data'])) {
            header('Location: /donasi');
            exit;
        }

        $data = [
            'title' => 'Donasi Berhasil - ' . APP_NAME,
            'donation' => $_SESSION['donation_data'],
            'rekening' => $this->donationModel->getRekening()
        ];

        // Hapus data session setelah ditampilkan
        unset($_SESSION['donation_data']);
        
        $this->view('donations/success', $data);
    }
}
?>