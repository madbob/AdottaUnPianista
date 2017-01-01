<?php

$days = $event->days();
$slots = [];
foreach($days as $d)
    $slots[] = $event->slots()->where(DB::raw('DATE(date)'), $d->date)->orderBy('date', 'asc')->get();

$available = true;

?>

<h1>{{ $event->name }}</h1>

<p>
    {!! nl2br($event->description) !!}
</p>

@if($event->status == 'published')
    <table class="table cells">
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
