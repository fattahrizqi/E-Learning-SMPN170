<?php

namespace App\helpers;
use DateTime;
use DateTimeZone;

class Time {
    public function friendlyTime($time)
    {
        // created_at formatting
        $created_at = $time;
        // Set the timezone to Jakarta, Indonesia
        $timezone = new DateTimeZone('Asia/Jakarta');
        // Convert the "created_at" string to a DateTime object
        $datetime = new DateTime($created_at, $timezone);
        // Get the current time as a DateTime object
        $current_time = new DateTime('now', $timezone);
        // Calculate the time difference between the "created_at" value and the current time
        $interval = $datetime->diff($current_time);

        // Format the time difference as a string
        if ($interval->y >= 1) {
            $time_since = $interval->format('%y year' . ($interval->y > 1 ? 's' : '') . ' ago');
        } elseif ($interval->m >= 1) {
            $time_since = $interval->format('%m month' . ($interval->m > 1 ? 's' : '') . ' ago');
        } elseif ($interval->d >= 1) {
            $time_since = $interval->format('%d day' . ($interval->d > 1 ? 's' : '') . ' ago');
        } elseif ($interval->h >= 1) {
            $time_since = $interval->format('%h hour' . ($interval->h > 1 ? 's' : '') . ' ago');
        } elseif ($interval->i >= 1) {
            $time_since = $interval->format('%i minute' . ($interval->i > 1 ? 's' : '') . ' ago');
        } else {
            $time_since = 'just now';
        }

        return $time_since;
    }
}