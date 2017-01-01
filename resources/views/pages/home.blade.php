@extends('layouts.app')

@section('title', 'Homepage')

@section('content')
    <div id="nav-sidebar">
        <a href="#grid">
        MENU
        </a>
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
