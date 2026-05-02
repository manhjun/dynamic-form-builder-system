<?php

namespace App\Helpers;

use Carbon\Carbon;

if (!function_exists('formatDate')) {
    function formatDate($date, string $format = 'Y/m/d')
    {
        if ($date instanceof Carbon) {
            return $date->format($format);
        }

        return $date;
    }
}