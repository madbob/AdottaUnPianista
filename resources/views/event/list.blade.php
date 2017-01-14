@extends('layouts.admin')

@section('title', 'Amministrazione Eventi')

@section('acontent')
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-default" data-toggle="modal" data-target="#new-event">Crea Nuovo Evento</button>
        </div>
    </div>

    <div class="modal fade" id="new-event" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Crea Nuovo Evento</h4>
                </div>

                {!! BootForm::open(['model' => new App\Event(), 'store' => 'EventController@store', 'update' => 'EventController@update']) !!}
                    <div class="modal-body">
                        {!! BootForm::text('name', 'Titolo') !!}
                        {!! BootForm::text('area', 'Area') !!}
                        {!! BootForm::text('start', 'Data Inizio', null, ['class' => 'date']) !!}
                        {!! BootForm::text('end', 'Data Fine', null, ['class' => 'date']) !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                        <button type="submit" class="btn btn-primary">Salva</button>
                    </div>
                {!! BootForm::close() !!}
            </div>
        </div>
    </div>

    <hr/>

    <div class="row">
        <div class="col-md-12">
            @if($events->isEmpty())
                <div class="alert alert-info">
                    <p>Non ci sono eventi</p>
                </div>
            @else
                <div class="list-group">
                    @foreach($events as $event)
                        <a href="{{ url('evento/' . $event->id . '/edit') }}" class="list-group-item {{ $event->status == 'published' ? 'active' : '' }}">
                            {{ $event->name }}<span class="badge">{{ $event->status == 'published' ? 'Aperto' : ($event->status == 'archived' ? 'Archiviato' : 'Chiuso') }}</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
