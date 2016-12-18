<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
        public function user()
        {
                return $this->belongsTo('App\User');
        }

        public function slot()
        {
                return $this->belongsTo('App\Slot');
        }

        public function attendees()
        {
                return $this->hasMany('App\Attendee');
        }
}
