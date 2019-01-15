<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Date;
use DB;

class Event extends Model
{
    public function slots()
    {
        return $this->hasMany('App\Slot');
    }

    public function days()
    {
        $days = [];
        $start = strtotime($this->start);
        $end = strtotime($this->end);

        while ($start < $end + 60 * 60 * 24) {
            $d = new Date($start);

            $days[] = (object) [
                'name' => ucwords($d->format('l')),
                'date' => strftime('%Y-%m-%d', $start),
            ];

            $start += 60 * 60 * 24;
        }

        return $days;
    }

    public function getPhotosAttribute()
    {
        $path = storage_path() . '/app/photos/' . $this->id;
        if (file_exists($path) == false)
            mkdir($path, 0777);
        return array_diff(scandir($path), ['..', '.']);
    }

    public function printableDate($type)
    {
        return ucwords(Date::parse($this->$type)->format('l d F Y'));
    }

    public function printableDates()
    {
        $start = strtotime($this->start);
        $end = strtotime($this->end);

        $start_day = date('d', $start);
        $start_month = ucwords(Date::parse($this->start)->format('F'));
        $start_year = date('Y', $start);
        $end_day = date('d', $end);
        $end_month = ucwords(Date::parse($this->end)->format('F'));
        $end_year = date('Y', $end);

        if ($start_month == $end_month) {
            return sprintf('%s/%s %s %s', $start_day, $end_day, $start_month, $start_year);
        }
        else {
            return sprintf('%s %s / %s %s', $start_day, $start_month, $end_day, $end_month);
        }
    }

    private static function globFiles($pattern, $ext)
    {
        $ret = [];
        $path = public_path() . '/images/events/';
        $files = glob($path . $pattern . '*');

        foreach($files as $f) {
            $filename = basename($f);
            preg_match("/$pattern([0-9]*).$ext/", $filename, $matches);
            $index = $matches[1];
            $ret[$index] = sprintf('<img src="/images/events/%s" class="img-responsive">', $filename);
        }

        return $ret;
    }

    public static function getCovers()
    {
        return self::globFiles('cover-', 'jpg');
    }

    public static function getIcons()
    {
        return self::globFiles('mini-', 'png');
    }

    public static function availableYears($future = false)
    {
        $ret = [];

        $min = Event::min('year');
        $max = Event::max('year');
        $start = $future ? $max + 1 : $max;

        for($i = $start; $i >= $min; $i--) {
            $ret[$i] = $i;
        }

        return $ret;
    }

    public static function currentYear()
    {
        return Event::whereIn('status', ['announced', 'published', 'archived'])->max('year');
    }
}
