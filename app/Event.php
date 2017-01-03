<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Date;

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
}
