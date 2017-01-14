@extends('layouts.admin')

@section('title', 'Modifica Location')

@section('acontent')
    <div class="row">
        <div class="col-md-12">
            {!! BootForm::open(['model' => $location, 'store' => 'AdoptionController@store', 'update' => 'AdoptionController@update']) !!}
                {!! BootForm::text('name', 'Nome') !!}
                {!! BootForm::text('surname', 'Cognome') !!}
                {!! BootForm::text('address', 'Indirizzo') !!}
                {!! BootForm::text('phone', 'Telefono') !!}
                {!! BootForm::email() !!}
                {!! BootForm::number('capacity', 'Posti Disponibili') !!}

                {!! BootForm::radios('status', 'Stato', [
                    'pending' => 'In Attesa',
                    'contacted' => 'Contattato',
                    'voided' => 'Scartato',
                    'confirmed' => 'Confermato (compare nella selezione dei concerti)',
                    'archived' => 'Archiviato',
                ], $location->status) !!}

                {!! BootForm::textarea('notes', 'Note') !!}
                {!! BootForm::submit('Salva') !!}
            {!! BootForm::close() !!}
        </div>
    </div>
@endsection
