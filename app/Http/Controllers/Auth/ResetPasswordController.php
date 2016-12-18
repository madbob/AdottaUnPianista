<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords {
        reset as true_reset;
    }

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function reset(Request $request)
    {
        /*
            Quando un utente resetta la password, assumo che il suo indirizzo
            mail sia valido (avendo ricevuto il token di reset)
        */
        $broker = $this->broker();
        $user = $broker->getUser(['email' => $request->input('email')]);
        if ($user != null) {
            if ($broker->getRepository()->exists($user, $request->input('token'))) {
                $user->verification_code = '';
                $user->save();
            }
        }

        return $this->true_reset($request);
    }
}
