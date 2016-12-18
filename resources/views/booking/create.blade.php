@extends('layouts.app')

@section('title', 'Prenota')

@section('content')
    <div class="row">
        <div class="col-md-12 text-center">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin sodales, mauris vitae tristique laoreet, massa libero ultrices sem, eget ultricies nibh augue a nibh. Praesent eu vulputate enim. Donec volutpat eget nisl quis posuere. Praesent dapibus quam et arcu mattis hendrerit. Aliquam mattis quis nulla non viverra. Quisque id felis eu orci efficitur vehicula tincidunt ut elit. Donec magna mi, aliquet vitae malesuada sit amet, tempor nec quam. Morbi ultrices feugiat tellus at mattis. Nunc et viverra neque. Curabitur efficitur condimentum euismod. Vestibulum vel nunc ipsum.
            </p>
        </div>
    </div>

    <?php

    $days = $event->days();
    $slots = [];
    foreach($days as $d)
        $slots[] = $event->slots()->where(DB::raw('DATE(date)'), $d->date)->orderBy('date', 'asc')->get();

    $available = true;

    ?>

    <div class="row">
        <div class="col-md-12">
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
	                                    @include('booking.cell', ['slot' => $slot, 'user' => $user])
	                                </td>
                                @endif
                            @endforeach
                        </tr>
                    @endwhile
                </tbody>
            </table>
        </div>
    </div>
@endsection
