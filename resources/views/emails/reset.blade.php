<p>
    Hai chiesto il reset della password su {{ env('APP_NAME') }}.
</p>
<p>
    Per continuare, visita il seguente link:<br/>
    <a href="{{ $link = url('password/reset', $token) }}">{{ $link }}</a>
</p>
