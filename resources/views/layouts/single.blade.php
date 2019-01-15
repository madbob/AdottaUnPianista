@extends('layouts.app')

@section('content')
    <div id="nav-sidebar">
        <a class="grid-opener" href="#grid"></a>
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
                        <img class="img-responsive" src="/images/events/mini-{{ $event->icon }}.png">
                        <p class="dates">{{ strtolower($event->printableDates()) }} | {{ $event->area }}</p>
                        <p class="title">{{ $event->name }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
