<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Mail;
use Session;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required|max:255',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    public function register(Request $request)
    {
        $input = $request->all();

        $validator = $this->validator($input);
        if ($validator->passes()){
            $user = (object) $this->create($input)->toArray();
            Mail::send('emails.activation', ['user' => $user], function($message) use ($user){
                $message->to($user->email);
                $message->subject(env('APP_NAME') . ': attivazione account');
            });

            Session::flash('message', 'Ti abbiamo inviato una mail per la conferma della registrazione');
            return redirect()->to('login');
        }

        return back()->with('errors', $validator->errors());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'verification_code' => str_random(15)
        ]);
    }


    public function activate(Request $request, $token)
    {
        $user = User::where('verification_code', $token)->first();
        if ($user == null) {
            Session::flash('message', 'Token non riconosciuto');
            return redirect()->to('login');
        }

        $user->verification_code = '';
        $user->save();

        Session::flash('message', 'Account validato, benvenuto su ' . env('APP_NAME'));
        return redirect()->to('login');
    }
}
