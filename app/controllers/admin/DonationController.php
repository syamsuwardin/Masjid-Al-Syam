<?php
class DonationController extends Controller {
    private $donationModel;

    public function __construct() {
        // Cek autentikasi admin
        if(!isset($_SESSION['admin'])) {
            header('Location: /admin/login');
            exit;
        }
        $this->donationModel = $this->model('Donation');
    }

    public function index() {
        $data = [
            'title' => 'Kelola Donasi - Admin',
            'donations' => $this->donationModel->getAllDonations(),
            'total_pending' => $this->donationModel->getTotalByStatus('pending'),
            'total_confirmed' => $this->donationModel->getTotalByStatus('confirmed')
        ];
        
        $this->view('admin/donations/index', $data);
    }

    public function confirm($id) {
        try {
            if($this->donationModel->updateStatus($id, 'confirmed')) {
                // Kirim email konfirmasi ke donatur
                $donation = $this->donationModel->getDonationById($id);
                if($donation && $donation['email']) {
                    // Logic untuk kirim email
                }
                $_SESSION['success'] = 'Donasi berhasil dikonfirmasi';
            } else {
                $_SESSION['error'] = 'Gagal mengkonfirmasi donasi';
            }
        } catch(Exception $e) {
            $_SESSION['error'] = 'Terjadi kesalahan sistem';
        }
        
        header('Location: /admin/donations');
        exit;
    }

    public function cancel($id) {
        try {
            if($this->donationModel->updateStatus($id, 'cancelled')) {
                $_SESSION['success'] = 'Donasi dibatalkan';
            } else {
                $_SESSION['error'] = 'Gagal membatalkan donasi';
            }
        } catch(Exception $e) {
            $_SESSION['error'] = 'Terjadi kesalahan sistem';
        }
        
        header('Location: /admin/donations');
        exit;
    }
}