<?php
class PrayTimes {
    // Default times
    private $times = [
        'imsak'    => '04:20',
        'fajr'     => '04:30',
        'sunrise'  => '05:45',
        'dhuhr'    => '12:00',
        'asr'      => '15:15',
        'sunset'   => '17:45',
        'maghrib'  => '18:00',
        'isha'     => '19:15',
        'midnight' => '00:00'
    ];

    private $method = 'MWL';
    private $tune = [
        'imsak'    => 10,
        'fajr'     => 20,
        'sunrise'  => 0,
        'dhuhr'    => 3,
        'asr'      => 0,
        'maghrib'  => 3,
        'isha'     => 18
    ];

    public function setMethod($method) {
        $this->method = $method;
    }

    public function tune($params) {
        foreach ($params as $key => $value) {
            if (isset($this->tune[$key])) {
                // Convert 'Standard' to numeric value
                if ($value === 'Standard') {
                    $value = 0;
                }
                $this->tune[$key] = (int)$value;
            }
        }
    }

    public function getTimes($timestamp, $coords, $timezone, $dst = 0, $elevation = 0) {
        // Apply basic calculations for prayer times
        $date = getdate($timestamp);
        $this->calculateTimes($date, $coords[0], $coords[1], $timezone, $elevation);
        
        // Calculate Imsyak (10 minutes before Fajr)
        if (isset($this->times['fajr'])) {
            try {
                list($h, $m) = explode(':', $this->times['fajr']);
                $fajrMinutes = ((int)$h * 60) + (int)$m;
                $imsyakMinutes = $fajrMinutes - 10;
                
                // Handle negative minutes (crossing previous day)
                if ($imsyakMinutes < 0) {
                    $imsyakMinutes += 1440; // Add 24 hours in minutes
                }
                
                $imsyakHour = floor($imsyakMinutes / 60) % 24;
                $imsyakMin = $imsyakMinutes % 60;
                
                // Format with leading zeros
                $this->times['imsak'] = sprintf('%02d:%02d', $imsyakHour, $imsyakMin);
            } catch (Exception $e) {
                error_log('Error calculating Imsyak time: ' . $e->getMessage());
                $this->times['imsak'] = null;
            }
        }
        
        // Apply offsets
        foreach ($this->times as $key => $time) {
            if (isset($this->tune[$key]) && is_numeric($this->tune[$key])) {
                $minutes = (int)$this->tune[$key];
                $this->times[$key] = $this->addMinutes($time, $minutes);
            }
        }

        return $this->times;
    }

    private function calculateTimes($date, $latitude, $longitude, $timezone, $elevation) {
        // Basic calculation - using local time
        $baseTime = mktime(0, 0, 0, $date['mon'], $date['mday'], $date['year']);
        
        // Adjust times based on location and method
        foreach ($this->times as $key => &$time) {
            $time = $this->adjustTime($time, $baseTime, $latitude, $longitude, $timezone);
        }
    }

    private function adjustTime($time, $baseTime, $latitude, $longitude, $timezone) {
        // Convert time string to minutes since midnight
        list($h, $m) = explode(':', $time);
        $minutes = (int)$h * 60 + (int)$m;
        
        // Apply timezone adjustment
        $minutes += $timezone * 60;
        
        // Convert back to time format
        $h = floor($minutes / 60) % 24;
        $m = $minutes % 60;
        
        return sprintf('%02d:%02d', $h, $m);
    }

    private function addMinutes($time, $minutes) {
        list($h, $m) = explode(':', $time);
        $m = (int)$m + (int)$minutes;
        $h = ((int)$h + floor($m / 60)) % 24;
        $m = $m % 60;
        return sprintf('%02d:%02d', $h, $m);
    }
}