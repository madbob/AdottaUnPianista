<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Date;

class Slot extends Model
{
    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function location()
    {
        return $this->belongsTo('App\Adoption', 'location_id');
    }

    public function getAvailableAttribute()
    {
        $capacity = $this->location->capacity;
        $attendees = 0;

        foreach ($this->bookings as $booking) {
            $attendees += $booking->attendees->count();
        }

        return $capacity - $attendees;
    }

    public function printableDate()
    {
        return ucwords(Date::parse($this->date)->format('l d F Y'));
    }

    public function printableHour()
    {
        $t = strtotime($this->date);

        return strftime('%H:%M', $t);
    }
}
