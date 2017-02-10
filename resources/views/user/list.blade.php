@extends('layouts.admin')

@section('title', 'Amministrazione Utenti')

@section('acontent')
	<div class="row">
		<div class="col-md-12">
			<button class="btn btn-default" data-toggle="modal" data-target="#new-user">Crea Nuovo Utente</button>
            <button class="btn btn-default" data-toggle="modal" data-target="#new-mail">Invia Mail Massiva</button>
		</div>
	</div>

	<div class="modal fade" id="new-user" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Crea Nuovo Evento</h4>
				</div>

				{!! BootForm::open(['action' => 'UserController@store']) !!}
					<div class="modal-body">
						{!! BootForm::text('name', 'Nome') !!}
						{!! BootForm::text('surname', 'Cognome') !!}
						{!! BootForm::text('phone', 'Telefono') !!}
						{!! BootForm::email() !!}
						{!! BootForm::password('password', 'Password') !!}
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
						<button type="submit" class="btn btn-primary">Salva</button>
					</div>
				{!! BootForm::close() !!}
			</div>
		</div>
	</div>

    <div class="modal fade" id="new-mail" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Invia Mail a tutti gli Iscritti</h4>
				</div>

				{!! BootForm::open(['action' => 'UserController@sendMail']) !!}
					<div class="modal-body">
                        <div class="alert alert-info">
                            Manda una mail a tutti gli iscritti alla piattaforma.
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

	<hr/>

	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<thead>
					<tr>
						<th>Nome</th>
						<th>Cognome</th>
						<th>Telefono</th>
						<th>E-Mail</th>
					</tr>
				</thead>
				<tbody>
					@foreach($users as $user)
						<tr>
							<td>{{ $user->name }}</td>
							<td>{{ $user->surname }}</td>
							<td>{{ $user->phone }}</td>
							<td>{{ $user->email }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			{{ $users->links() }}
		</div>
	</div>
@endsection
