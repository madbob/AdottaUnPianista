<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'surname', 'email', 'phone', 'password', 'verification_code',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    public function sendPasswordResetNotification($token)
    {
        $user = $this;
        Mail::send('emails.reset', ['token' => $token], function($message) use ($user){
            $message->to($user->email);
            $message->subject(env('APP_NAME') . ': reset password');
        });
    }
}
