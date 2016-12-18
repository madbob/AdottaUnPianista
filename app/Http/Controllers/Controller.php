<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function decodeDate($date)
    {
        if ($date == '') {
            return '';
        }

        $months = [
            'gennaio' => 'january',
            'febbraio' => 'february',
            'marzo' => 'march',
            'aprile' => 'april',
            'maggio' => 'may',
            'giugno' => 'june',
            'luglio' => 'july',
            'agosto' => 'august',
            'settembre' => 'september',
            'ottobre' => 'october',
            'novembre' => 'november',
            'dicembre' => 'december',
        ];

        list($weekday, $day, $month, $year) = explode(' ', $date);
        $en_date = sprintf('%s %s %s', $day, $months[strtolower($month)], $year);

        return date('Y-m-d', strtotime($en_date));
    }
}
