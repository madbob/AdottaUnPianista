@extends('layouts.app')

@section('title', 'Homepage')

@section('content')
    <div id="nav-sidebar">
        <a class="grid-opener" href="#grid"></a>
    </div>

    <div id="grid">
        <div class="page active" id="home">
            <div class="cover">
                <div class="details">
                    <p>HOMEPAGE</p>
                </div>
            </div>
            <div class="contents">
                <div>
                    <div class="intro-wrapper">
                        <div class="intro-carousel">
                            <!--
                            <div class="slide" style="background-image: url('/images/pianista_sd.jpg')">
                                <a href="{{ url('adozione/create') }}">
                                    <div class="intro-info intro-info-bg-0">
                                        <p class="info-adoption">Abiti a San Donato?<br/>Hai un pianoforte in casa e vuoi ospitare un concerto? Scrivici e ti spieghiamo come funziona!</p>
                                    </div>
                                </a>
                            </div>
                            -->

                            <?php $index = 1 ?>
                            @foreach($events as $event)
                                <div class="slide" style="background-image: url('/images/events/cover-{{ $event->id }}.jpg')">
                                    <div class="intro-info intro-info-bg-{{ $index = (($index + 1) % 3) }}">
                                        <?php

                                        $start = strtotime($event->start);
                                        $end = strtotime($event->end);

                                        $start_day = date('d', $start);
                                        $start_month = ucwords(Date::parse($event->start)->format('F'));
                                        $start_year = date('Y', $start);
                                        $end_day = date('d', $end);
                                        $end_month = ucwords(Date::parse($event->end)->format('F'));
                                        $end_year = date('Y', $end);

                                        ?>

                                        <p class="info-days">{{ $start_day }} / {{ $end_day }}</p>
                                        <p class="info-month">{{ $start_month }}</p>
                                        <p class="info-year">{{ $start_year }}</p>
                                        <p class="info-area">{{ $event->area }}</p>
                                        <p class="info-name">{{ $event->name }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="intro-text">
                        <?php $user = Auth::user() ?>
                        @if($user)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info text-center">
                                        @if($user->admin == true)
                                            <a href="/evento">Amministrazione</a> |
                                        @endif

                                        <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mm-block">
                            <p class="major-text">
                                Adotta un pianista è un programma di concerti da realizzare negli appartamenti privati dei quartieri di San Salvario, San Donato, Barriera di Milano, Aurora Porta Palazzo, Mirafiori nord,  i cui proprietari si rendano disponibili ad accogliere musicisti e pubblico in casa propria.
                            </p>

                            <p class="minor-text">
                                Agli abitanti dei quartieri coinvolti che siano in possesso di un pianoforte viene chiesto di ospitare un piccolo concerto nel proprio appartamento, segnalando la propria disponibilità al sito www.adottaunpianista.it indicando l’orario più consono e il numero di spettatori che l’appartamento è in grado di accogliere.
                            </p>
                        </div>

                        <div class="hp-events">
                            @foreach($events as $event)
                                <div class="hp-event">
                                    <a href="event-{{ str_slug($event->name) }}">
                                        <div class="booking-head">
                                            <span class="area">{{ strtolower($event->printableDates()) }}, {{ $event->area }}</span> <span class="name">{{ $event->name }}</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <div class="generic-button-large">
                            <a href="{{ url('adozione/create') }}"><img src="/images/filetto1_right.svg"><span>VUOI OSPITARE UN CONCERTO A CASA TUA?</span><img src="/images/filetto1_left.svg"></a>
                        </div>

                        <div class="logos">
                            <img src="/images/loghi.jpg">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach($events as $event)
            <div class="page" id="event-{{ str_slug($event->name) }}">
                <div class="cover event-cell">
                    <div class="details">
                        <img class="img-responsive" src="/images/events/mini-{{ $event->id }}.png">
                        <p class="dates">{{ strtolower($event->printableDates()) }} | {{ $event->area }}</p>
                        <p class="title">{{ $event->name }}</p>
                    </div>
                </div>
                <div class="contents">
                    @include('booking.create', ['event' => $event])
                </div>
            </div>
        @endforeach
    </div>
@endsection
