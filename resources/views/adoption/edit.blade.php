@extends('layouts.app')

@if($location->exists == false)
    @section('title', 'Candida Location')
@else
    @section('title', 'Modifica Location')
@endif

@section('content')
    @if($location->exists == false)
        <div class="row">
            <div class="col-md-12 text-center">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin sodales, mauris vitae tristique laoreet, massa libero ultrices sem, eget ultricies nibh augue a nibh. Praesent eu vulputate enim. Donec volutpat eget nisl quis posuere. Praesent dapibus quam et arcu mattis hendrerit. Aliquam mattis quis nulla non viverra. Quisque id felis eu orci efficitur vehicula tincidunt ut elit. Donec magna mi, aliquet vitae malesuada sit amet, tempor nec quam. Morbi ultrices feugiat tellus at mattis. Nunc et viverra neque. Curabitur efficitur condimentum euismod. Vestibulum vel nunc ipsum.
                </p>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            {!! BootForm::open(['model' => $location, 'store' => 'AdoptionController@store', 'update' => 'AdoptionController@update']) !!}
                {!! BootForm::text('name', 'Nome') !!}
                {!! BootForm::text('surname', 'Cognome') !!}
                {!! BootForm::text('address', 'Indirizzo') !!}
                {!! BootForm::text('phone', 'Telefono') !!}
                {!! BootForm::email() !!}

                @if($location->exists)
                    {!! BootForm::number('capacity', 'Posti Disponibili') !!}

                    {!! BootForm::radios('status', 'Stato', [
                        'pending' => 'In Attesa',
                        'contacted' => 'Contattato',
                        'voided' => 'Scartato',
                        'confirmed' => 'Confermato (compare nella selezione dei concerti)',
                        'archived' => 'Archiviato',
                    ], $location->status) !!}
                @endif

                {!! BootForm::textarea('notes', 'Note') !!}

                @if($location->exists)
                    {!! BootForm::submit('Salva') !!}
                @else
                    {!! BootForm::submit('Invia Candidatura') !!}
                @endif
            {!! BootForm::close() !!}
        </div>
    </div>
@endsection
