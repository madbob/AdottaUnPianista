@extends('layouts.admin')

@section('title', 'Modifica Evento')

@section('acontent')
    <div class="page-header">
        <h2>Info</h2>
    </div>

    <div class="row">
        <div class="col-md-12">
            {!! BootForm::open(['model' => $event, 'store' => 'EventController@store', 'update' => 'EventController@update']) !!}

                {!! BootForm::text('name', 'Titolo') !!}
                {!! BootForm::text('area', 'Area') !!}
                {!! BootForm::textarea('description', 'Introduzione') !!}
                {!! BootForm::text('start', 'Data Inizio', $event->printableDate('start'), ['class' => 'date']) !!}
                {!! BootForm::text('end', 'Data Fine', $event->printableDate('end'), ['class' => 'date']) !!}
                {!! BootForm::radios('status', 'Stato', [
                    'closed' => 'Visibile solo agli amministratori',
                    'announced' => 'Visibile solo data e intro',
                    'published' => 'Visibile pubblicamente e prenotabile',
                    'archived' => 'Archiviato in sola lettura',
                ], $event->status) !!}
                {!! BootForm::submit('Salva') !!}

            {!! BootForm::close() !!}
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 form-horizontal">
            <div class="form-group">
                <div class="col-md-10 col-md-offset-2">
                    <button class="btn btn-default" data-toggle="modal" data-target="#new-mail">Invia Mail a tutti i Partecipanti</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="new-mail" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Invia Mail a tutti i Partecipanti</h4>
				</div>

				{!! BootForm::open(['action' => 'EventController@sendMail']) !!}
					<div class="modal-body">
                        <div class="alert alert-info">
                            Manda una mail a tutti i partecipanti all'evento (tutti gli indirizzi mail registrati per tutti i concerti).
                        </div>

                        {!! BootForm::text('subject', 'Oggetto') !!}
                        {!! BootForm::textarea('body', 'Testo') !!}
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
						<button type="submit" class="btn btn-primary">Salva</button>
					</div>
				{!! BootForm::close() !!}
			</div>
		</div>
	</div>

    <?php

    $days = $event->days();
    $slots = [];
    foreach($days as $d)
        $slots[] = $event->slots()->where(DB::raw('DATE(date)'), $d->date)->orderBy('date', 'asc')->get();

    $available = true;

    ?>

    <hr/>

    <div class="page-header">
        <h2>Concerti</h2>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table">
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

                                $node = $collection->shift();
                                if ($node == null):
                                    $available = $available || false;
                                    ?>

                                    <td>&nbsp;</td>

                                    <?php
                                else:
                                    $available = true;
                                    ?>

                                    <td>
                                        @include('event.cell', ['slot' => $node])
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @endwhile

                    <tr>
                        @foreach($days as $d)
                            <td>
                                <button class="btn btn-default" data-toggle="modal" data-target="#new-slot-{{ $d->date }}">Aggiungi Concerto</button>

                                <div class="modal fade" id="new-slot-{{ $d->date }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Crea Nuovo Concerto</h4>
                                            </div>

                                            {!! BootForm::open(['action' => 'SlotController@store']) !!}
                                                <div class="modal-body">
                                                    {!! BootForm::hidden('event_id', $event->id) !!}
                                                    {!! BootForm::hidden('date', $d->date) !!}
                                                    {!! BootForm::text('hour', 'Orario') !!}
                                                    {!! BootForm::text('name', 'Titolo') !!}
                                                    {!! BootForm::textarea('artist', 'Artista') !!}
                                                    {!! BootForm::textarea('contents', 'Programma') !!}

                                                    <div class="form-group">
                                                        <label for="location" class="col-sm-2 control-label">Location</label>
                                                        <div class="col-sm-10">
                                                            <select name="location" class="form-control" required>
                                                                @foreach(App\Adoption::where('status', 'confirmed')->orderBy('surname', 'asc')->get() as $location)
                                                                    <option value="{{ $location->id }}">{{ $location->name }} {{ $location->surname }}, {{ $location->address }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                                    <button type="submit" class="btn btn-default">Salva</button>
                                                </div>
                                            {!! BootForm::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <hr/>

    <div class="page-header">
        <h2>Galleria Fotografica</h2>
    </div>

    <div class="row">
        @foreach($event->photos as $photo)
        <div class="col-md-3 event-photo">
            <form method="POST" action="{{ url('evento/' . $event->id . '/foto/' . $photo) }}">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="delete">
                <button type="submit">Elimina</button>
            </form>
            <img class="img-responsive" src="{{ url('evento/' . $event->id . '/foto/' . $photo) }}">
        </div>
        @endforeach
    </div>

    <br/>

    <div class="row">
        <form action="{{ url('evento/' . $event->id . '/foto') }}" class="dropzone" id="event-{{ $event->id }}-dropzone">
            {{ csrf_field() }}
        </form>
    </div>

    <br/>

	<script>
		var locations = [
			@foreach(App\Adoption::where('status', 'confirmed')->orderBy('surname', 'asc')->get() as $location)
				{
					id: "{{ $location->id }}",
					name: "{{ $location->name }} {{ $location->surname }}",
					address: "{{ $location->address }}",
					capacity: "{{ $location->capacity }}",
					phone: "{{ $location->phone }}",
					email: "{{ $location->email }}",
				},
			@endforeach
		];
	</script>
@endsection
