<?php

$days = $event->days();

?>

<div class="row">
    <div class="col-md-12">
        <div class="booking-head">
            <span class="area">{{ trim($event->area) }}</span> <span class="name">{{ trim($event->name) }}</span>
        </div>

        <p>
            <p>{!! nl2br(trim($event->description)) !!}</p>
        </p>
    </div>
</div>

<div class="row bookable-concerts">
    @if($event->status == 'published')
        @if(Auth::user() == null)
            <div class="col-md-12">
                <div class="generic-button-large">
                    <a href="/login">Per prenotare, occorre essere registrati.<br/>Clicca qui per autenticarti o registrarti.</a>
                </div>
            </div>
        @endif

        @foreach($days as $index => $d)
            <div class="col-md-{{ 12 / count($days) }} cells column-{{ $index }}">
                <div class="day-name">
                    {{ $d->name }}
                </div>

                @foreach($event->slots()->where(DB::raw('DATE(date)'), $d->date)->orderBy('date', 'asc')->get() as $slot)
                    @include('booking.cell', ['slot' => $slot, 'user' => Auth::user()])
                @endforeach
            </div>
        @endforeach
    @else
        <div class="alert alert-info">
            <p>Programma da definire</p>
        </div>
    @endif
</div>
