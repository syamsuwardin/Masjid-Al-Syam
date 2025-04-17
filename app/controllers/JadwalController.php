<?php
class JadwalController extends Controller {
    private $prayerModel;
    private $jumatModel;

    public function __construct() {
        $this->prayerModel = $this->model('Prayer');
        $this->jumatModel = $this->model('JumatSchedule');
    }

    public function index() {
        try {
            $data = [
                'title' => 'Jadwal Sholat - ' . APP_NAME,
                'prayer_times' => $this->prayerModel->getTodayPrayerTimes(),
                'weekly_prayers' => $this->prayerModel->getWeeklyPrayers(),
                'monthly_schedule' => $this->prayerModel->getMonthlyJumatSchedule(),
                'next_prayer' => $this->getNextPrayer(),
                'jumat_schedules' => $this->jumatModel->getUpcomingSchedules()
            ];
            
            $this->view('jadwal/index', $data);
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->view('errors/index', [
                'title' => 'Error - ' . APP_NAME,
                'message' => 'Terjadi kesalahan saat memuat jadwal.'
            ]);
        }
    }

    private function getNextPrayer() {
        $times = $this->prayerModel->getTodayPrayerTimes();
        $now = date('H:i');
        
        $prayers = [
            'fajr' => 'Subuh',
            'dhuhr' => 'Dzuhur',
            'asr' => 'Ashar',
            'maghrib' => 'Maghrib',
            'isha' => 'Isya'
        ];

        foreach ($prayers as $key => $name) {
            if ($times[$key] > $now) {
                return [
                    'name' => $name,
                    'time' => $times[$key]
                ];
            }
        }

        // Jika semua waktu sholat hari ini sudah lewat, return subuh besok
        return [
            'name' => 'Subuh',
            'time' => $times['fajr']
        ];
    }
}