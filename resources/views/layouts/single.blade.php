@extends('layouts.app')

@section('content')
    <div id="nav-sidebar">
        <a class="btn btn-default grid-opener" href="#grid"><img src="http://placehold.it/350x150"></a>
    </div>

    <div id="grid">
        <div class="page active" id="current">
            <div class="contents">
                @yield('single_content')
            </div>
        </div>

        <div class="page" id="home">
            <div class="cover">
                <div class="details">
                    <p>HOMEPAGE</p>
                </div>
            </div>
        </div>

        @foreach($events as $event)
            <div class="page" id="event-{{ str_slug($event->name) }}">
                <div class="cover event-cell">
                    <div class="details">
                        <img src="/images/events/mini-{{ $event->id }}.png">
                        <p class="dates">{{ strtolower($event->printableDates()) }} | {{ $event->area }}</p>
                        <p class="title">{{ $event->name }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
