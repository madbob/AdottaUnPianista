<?php

if (Auth::check()) {
    $booking = $user->bookings()->where('slot_id', $slot->id)->first();
    $modificable = $slot->bookable && ($slot->isElapsed() == false);
}
else {
    $booking = null;
    $modificable = false;
}

?>

<div class="panel" data-slot-id="{{ $slot->id }}">
    <div class="panel-heading">
        Ore {{ $slot->printableHour() }} {{ !empty($slot->name) ? ' - ' . trim($slot->name) : '' }}
    </div>

    @if($slot->status == 'cancelled')
        <div class="panel-body">
            <p class="lead">
                ANNULLATO
            </p>
        </div>
        <div class="panel-footer">
            <button class="btn btn-danger" disabled>Prenota</button>
        </div>
    @else
        <div class="panel-body">
            <p class="lead">
                {!! nl2br(trim($slot->artist)) !!}
            </p>
            <small>
                {!! nl2br(trim($slot->contents)) !!}
            </small>
        </div>
        <div class="panel-footer">
            @if($modificable)
                @if($booking != null)
                    <button class="btn" type="button" data-toggle="collapse" data-target="#book-slot-{{ $slot->id }}" aria-expanded="false" aria-controls="prenota">Modifica Prenotazione</button>
                @else
                    @if($slot->available != 0)
                        <button class="btn" type="button" data-toggle="collapse" data-target="#book-slot-{{ $slot->id }}" aria-expanded="false" aria-controls="prenota">Prenota</button>
                    @endif
                @endif
            @endif

            @if($slot->bookable)
                <span class="still-available-wrapper">
                    <span class="still-available">{{ $slot->available }}</span> Posti Disponibili
                </span>
            @endif

            <input type="hidden" name="max-bookable" value="{{ min($slot->available, 5) }}">
        </div>
    @endif
</div>

@if($modificable)
    <div class="collapse booking-form" id="book-slot-{{ $slot->id }}">
        <form method="POST" action="{{ url('prenotazione') }}" class="running-booking-form">
            <input type="hidden" name="slot_id" value="{{ $slot->id }}">
            {!! csrf_field() !!}

            <table class="table many-rows">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if($booking == null)
                        <tr class="fields">
                            <td><input type="text" name="name[]" class="form-control" value="{{ $user->name }}"></td>
                            <td><input type="text" name="surname[]" class="form-control" value="{{ $user->surname }}"></td>
                            <td><button class="delete-many-rows"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td>
                        </tr>
                        <tr class="fields">
                            <td><input type="text" name="name[]" class="form-control" value=""></td>
                            <td><input type="text" name="surname[]" class="form-control" value=""></td>
                            <td><button class="delete-many-rows"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td>
                        </tr>
                    @else
                        @foreach($booking->attendees as $attendee)
                            <tr class="fields">
                                <td><input type="text" name="name[]" class="form-control" value="{{ $attendee->name }}"></td>
                                <td><input type="text" name="surname[]" class="form-control" value="{{ $attendee->surname }}"></td>
                                <td><button class="delete-many-rows"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td>
                            </tr>
                        @endforeach
                    @endif

                    @if($slot->available > 1)
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><button class="add-many-rows"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <button type="submit" class="btn">Salva</button>

            @if($booking != null)
                <button class="btn delete-booking">Annulla Prenotazione</button>
            @endif
        </form>
    </div>
@endif
