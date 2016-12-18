<p>
    Ti sei registrato su {{ env('APP_NAME') }}.
</p>
<p>
    Per confermare il tuo account, visita il seguente link:<br/>
    <a href="{{ $link = url('register/activate', $user->verification_code) }}">{{ $link }}</a>
</p>
