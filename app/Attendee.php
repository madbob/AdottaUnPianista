<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    public function booking()
    {
        return $this->belongsTo('App\Booking');
    }

    public function getRealMailAttribute()
    {
        if (empty($this->email))
            return $this->booking->user->email;
        else
            return $this->email;
    }

    public function getRealPhoneAttribute()
    {
        if (empty($this->phone))
            return $this->booking->user->phone;
        else
            return $this->phone;
    }
}
