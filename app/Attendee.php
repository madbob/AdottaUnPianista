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
            $this->email;
    }

    public function getRealPhoneAttribute()
    {
        if (empty($this->phone))
            return $this->booking->user->phone;
        else
            $this->phone;
    }
}
