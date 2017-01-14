<?php

$days = $event->days();
$slots = [];
foreach($days as $d)
    $slots[] = $event->slots()->where(DB::raw('DATE(date)'), $d->date)->orderBy('date', 'asc')->get();

$available = true;

?>

<div class="event-cell">
    <div class="details">
        <img class="img-responsive" src="/images/events/mini-{{ $event->id }}.png">
        <p class="dates">{{ strtolower($event->printableDates()) }} | {{ $event->area }}</p>
        <p class="title">{{ $event->name }}</p>
        <p class="dates">{!! nl2br($event->description) !!}</p>
    </div>
</div>

@if($event->status == 'published')
    @if(Auth::user() == null)
        <div class="generic-button-large">
            <a href="/login">Per prenotare, occorre essere registrati.<br/>Clicca qui per autenticarti o registrarti.</a>
        </div>
    @endif

    <table class="table cells bookable-concerts">
        <thead>
            <tr>
                @foreach($days as $d)
                    <th width="{{ round(100 / count($days), 2) }}%">{{ $d->name }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @while($available)
                <?php $available = false ?>
                <tr>
                    @foreach($slots as $collection)
                        <?php

                        $slot = $collection->shift();
                        if ($slot == null):
                            $available = $available || false;
                            ?>

                            <td>&nbsp;</td>

                            <?php
                        else:
                            $available = true;

                            ?>

                            <td>
                                @include('booking.cell', ['slot' => $slot, 'user' => Auth::user()])
                            </td>
                        @endif
                    @endforeach
                </tr>
            @endwhile
        </tbody>
    </table>
@else
    <div class="alert alert-info">
        <p>Programma da definire</p>
    </div>
@endif
