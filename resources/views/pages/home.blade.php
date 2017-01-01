@extends('layouts.app')

@section('title', 'Homepage')

@section('content')
    <div id="nav-sidebar">
        <a class="btn btn-default" href="#grid">MENU</a>

        @if (Auth::guest())
            <a class="btn btn-default" href="{{ url('/login') }}">Login</a>
        @else
            @if(Auth::user()->admin == true)
                <a class="btn btn-default" href="{{ url('/evento') }}">Amministrazione</a>
            @endif

            <a class="btn btn-default" href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        @endif
    </div>

    <div id="grid">
        <div class="page active" id="home">
            <div class="cover">
                <p>
                    HOMEPAGE
                </p>
            </div>
            <div class="contents">
                <div class="col-md-12">
                    <h1>Adotta un pianista</h1>
                    <h2>Musica da camera in camera tua</h2>

                    <p>
                        Un progetto di Associazione Glocal Sounds (logo) e Agenzia sviluppo San Salvario onlus (logo)<br/>
                        Maggior sostenitore Compagnia di San Paolo (logo)
                    </p>

                    <h3>COS'È</h3>

                    <p>
                        Adotta un pianista è un programma di concerti da realizzare negli appartamenti privati dei quartieri di San Salvario, San Donato, Barriera di Milano, Aurora Porta Palazzo, Mirafiori nord,  i cui proprietari si rendano disponibili ad accogliere musicisti e pubblico in casa propria.
                    </p>

                    <p>
                        Agli abitanti dei quartieri coinvolti che siano in possesso di un pianoforte viene chiesto di ospitare un piccolo concerto nel proprio appartamento, segnalando la propria disponibilità al sito www.adottaunpianista.it indicando l’orario più consono e il numero di spettatori che l’appartamento è in grado di accogliere.
                    </p>

                    <hr/>

                    <a class="btn btn-default" href="{{ url('adozione/create') }}">VUOI OSPITARE UN CONCERTO A CASA TUA?</a>

                    <hr/>

                    <p>
                        Con il Patrocinio della Città di Torino (logo) e della Circoscrizione 8 (logo), della Circoscrizione 4 (logo), della Circoscrizione 6 (logo), della Circoscrizione 7 (logo), della Circoscrizione 2 (logo)
                    </p>

                    <p>
                        In collaborazione con
                    </p>

                    <ul>
                        <li>Conservatorio Statale di Musica “G.Verdi” di Torino (logo)</li>
                        <li>Conservatorio Statale di Musica “G.F. Ghedini” di Cuneo (logo)</li>
                        <li>Conservatorio Statale di Musica “A.Vivaldi” di Alessandria (logo)</li>
                        <li></li>
                        <li>+ SpazioQuattro (logo)</li>
                        <li>Hub Cecchi Point (logo)</li>
                        <li>Cascina Roccafranca (logo)</li>
                        <li>Bagni Pubblici di Via Agliè (logo)</li>
                        <li></li>
                        <li>Officina Informatica Libera (logo)</li>
                    </ul>
                </div>
            </div>
        </div>

        @foreach($events as $event)
            <div class="page" id="event-{{ str_slug($event->name) }}">
                <div class="cover">
                    <p>
                        {{ $event->name }}
                    </p>
                </div>
                <div class="contents">
                    @include('booking.create', ['event' => $event])
                </div>
            </div>
        @endforeach
    </div>
@endsection
