<?php
// filepath: c:\laragon\www\al-syam-mosque\app\models\Prayer.php

class Prayer {
    private $db;
    private $cityCode = 1277; // Kode kota Aceh Singkil
    private $apiUrl = 'https://bimasislam.kemenag.go.id/jadwalshalat/ajax/getjadwalshalat';
    // Update koordinat sesuai lokasi Masjid Al-Syam di Singkil Utara
    private $latitude = 2.3279;  // Latitude Singkil Utara
    private $longitude = 97.7851; // Longitude Singkil Utara
    private $timezone = 7; // GMT+7 untuk Aceh
    private $elevation = 5; // Estimasi ketinggian dari permukaan laut (dalam meter)

    public function __construct() {
        $this->db = new Database;
    }

    public function getTodayPrayerTimes() {
        $date = date('Y-m-d');
        
        // Cek apakah data hari ini sudah ada
        $this->db->query('SELECT * FROM prayer_times WHERE date = :date');
        $this->db->bind(':date', $date);
        $result = $this->db->single();

        if (!$result) {
            // Jika belum ada, generate dan simpan
            $times = $this->generatePrayerTimes($date);
            $this->savePrayerTimes($date, $times);
            return $times;
        }

        return $result;
    }

    public function generatePrayerTimes($date) {
        $prayTimesPath = dirname(__DIR__) . '/libs/PrayTimes.php';
        require_once $prayTimesPath;
        
        $prayTimes = new PrayTimes();
        
        // Set metode perhitungan - menggunakan metode Kementerian Agama Indonesia
        $prayTimes->setMethod('MWL');
        
        // Set pengaturan khusus untuk Indonesia
        $prayTimes->tune([
            'imsak' => 10,    // 10 menit sebelum Subuh
            'fajr' => 20,     // 20° untuk waktu Subuh
            'dhuhr' => 3,     // +3 menit untuk kehati-hatian
            'asr' => 'Standard',  // Standar (bayangan = tinggi benda)
            'maghrib' => 3,   // +3 menit setelah matahari terbenam
            'isha' => 18      // 18° untuk waktu Isya
        ]);

        // Get prayer times
        $times = $prayTimes->getTimes(
            strtotime($date), 
            [$this->latitude, $this->longitude], 
            $this->timezone, 
            0, // DST
            $this->elevation
        );

        return [
            'imsak' => date('H:i', strtotime($times['imsak'])),
            'fajr' => date('H:i', strtotime($times['fajr'])),
            'sunrise' => date('H:i', strtotime($times['sunrise'])),
            'dhuhr' => date('H:i', strtotime($times['dhuhr'])),
            'asr' => date('H:i', strtotime($times['asr'])),
            'maghrib' => date('H:i', strtotime($times['maghrib'])),
            'isha' => date('H:i', strtotime($times['isha']))
        ];
    }

    private function savePrayerTimes($date, $times) {
        $this->db->query('INSERT INTO prayer_times (date, imsyak, fajr, sunrise, dhuhr, asr, maghrib, isha) 
                         VALUES (:date, :imsyak, :fajr, :sunrise, :dhuhr, :asr, :maghrib, :isha)');
        
        $this->db->bind(':date', $date);
        $this->db->bind(':imsyak', $times['imsak']);
        $this->db->bind(':fajr', $times['fajr']);
        $this->db->bind(':sunrise', $times['sunrise']);
        $this->db->bind(':dhuhr', $times['dhuhr']);
        $this->db->bind(':asr', $times['asr']);
        $this->db->bind(':maghrib', $times['maghrib']);
        $this->db->bind(':isha', $times['isha']);

        return $this->db->execute();
    }

    public function getTodayPrayers() {
        try {
            $today = date('Y-m-d');
            $this->db->query('SELECT * FROM prayer_times WHERE date = :date');
            $this->db->bind(':date', $today);
            
            $result = $this->db->single();
            
            if ($result) {
                return [
                    'Imsyak' => date('H:i', strtotime($result['imsyak'])),
                    'Subuh' => date('H:i', strtotime($result['fajr'])),
                    'Dzuhur' => date('H:i', strtotime($result['dhuhr'])),
                    'Ashar' => date('H:i', strtotime($result['asr'])),
                    'Maghrib' => date('H:i', strtotime($result['maghrib'])),
                    'Isya' => date('H:i', strtotime($result['isha']))
                ];
            }

            // Fallback jika data tidak ditemukan
            return [
                'Imsyak' => '04:20',
                'Subuh' => '04:30',
                'Dzuhur' => '12:00',
                'Ashar' => '15:15',
                'Maghrib' => '18:00',
                'Isya' => '19:15'
            ];
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getWeeklyPrayers() {
        try {
            // Cek cache dulu
            $cached = $this->getCachedSchedule();
            if ($cached) {
                return $cached;
            }

            // Siapkan data untuk request
            $year = date('Y');
            $month = date('m');
            $data = [
                'tahun' => $year,
                'bulan' => $month,
                'h' => $this->cityCode
            ];

            // Buat cURL request
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            curl_close($ch);

            if ($response === false) {
                throw new Exception('Gagal mengambil data dari API Kemenag');
            }

            $result = json_decode($response, true);
            
            if (!$result || !isset($result['data'])) {
                throw new Exception('Format response tidak valid');
            }

            // Format data untuk 7 hari ke depan
            $weekly_prayers = [];
            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            
            for ($i = 0; $i < 7; $i++) {
                $currentDate = date('Y-m-d', strtotime("+$i days"));
                $dayIndex = date('w', strtotime("+$i days"));
                $dayData = $result['data'][$dayIndex] ?? null;

                if ($dayData) {
                    $weekly_prayers[] = [
                        'day' => $days[$dayIndex == 0 ? 6 : $dayIndex - 1],
                        'date' => $currentDate,
                        'times' => [
                            'imsak' => $dayData['imsak'],
                            'subuh' => $dayData['subuh'],
                            'dzuhur' => $dayData['dzuhur'],
                            'ashar' => $dayData['ashar'],
                            'maghrib' => $dayData['maghrib'],
                            'isya' => $dayData['isya']
                        ]
                    ];
                }
            }

            // Simpan ke cache
            $this->cacheSchedule($weekly_prayers);

            return $weekly_prayers;

        } catch (Exception $e) {
            error_log('Error getting prayer times: ' . $e->getMessage());
            // Return data fallback jika API gagal
            return $this->getFallbackSchedule();
        }
    }

    private function getCachedSchedule() {
        $this->db->query('SELECT schedule_data FROM prayer_cache 
                         WHERE date = CURDATE() AND updated_at >= DATE_SUB(NOW(), INTERVAL 6 HOUR)');
        $result = $this->db->single();
        
        return $result ? json_decode($result['schedule_data'], true) : null;
    }

    private function getFallbackSchedule() {
        // Data fallback jika API tidak tersedia
        $weekly_prayers = [];
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        
        for ($i = 0; $i < 7; $i++) {
            $weekly_prayers[] = [
                'day' => $days[$i],
                'date' => date('Y-m-d', strtotime("+$i days")),
                'times' => [
                    'imsak' => '04:30',
                    'subuh' => '04:45',
                    'dzuhur' => '12:15',
                    'ashar' => '15:30',
                    'maghrib' => '18:15',
                    'isya' => '19:30'
                ]
            ];
        }
        
        return $weekly_prayers;
    }

    // Add cache method to save API results
    private function cacheSchedule($data) {
        $this->db->query('INSERT INTO prayer_cache (date, schedule_data) 
                         VALUES (:date, :data)
                         ON DUPLICATE KEY UPDATE schedule_data = :data');
        
        $this->db->bind(':date', date('Y-m-d'));
        $this->db->bind(':data', json_encode($data));
        
        return $this->db->execute();
    }

    public function getMonthlySchedule() {
        // Contoh data jadwal Jumat
        return [
            'jumat_schedule' => [
                [
                    'date' => date('Y-m-d', strtotime('next friday')),
                    'imam' => 'Ust. Ahmad',
                    'khatib' => 'Ust. Muhammad'
                ],
                [
                    'date' => date('Y-m-d', strtotime('next friday +1 week')),
                    'imam' => 'Ust. Abdullah',
                    'khatib' => 'Ust. Ibrahim'
                ],
                [
                    'date' => date('Y-m-d', strtotime('next friday +2 week')),
                    'imam' => 'Ust. Umar',
                    'khatib' => 'Ust. Ali'
                ],
                [
                    'date' => date('Y-m-d', strtotime('next friday +3 week')),
                    'imam' => 'Ust. Yusuf',
                    'khatib' => 'Ust. Hamzah'
                ]
            ]
        ];
    }

    public function getMonthlyJumatSchedule() {
        return [
            'jumat_schedule' => [
                [
                    'date' => date('Y-m-d', strtotime('friday')),
                    'imam' => 'Ust. Ahmad',
                    'khatib' => 'Ust. Abdullah'
                ],
                // Add more weeks as needed
            ]
        ];
    }
}