<div class="panel panel-{{ $slot->status == 'open' ? 'success' : 'danger' }}" data-slot-id="{{ $slot->id }}">
    <div class="panel-heading">
        <div class="form-group">
            <label for="hour">Orario</label>
            <input type="text" name="hour" value="{{ $slot->printableHour() }}" class="form-control">
        </div>
    </div>
    <div class="panel-body">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#contents-{{ $slot->id }}" role="tab" data-toggle="tab">Contenuti</a></li>
            <li role="presentation"><a href="#location-{{ $slot->id }}" role="tab" data-toggle="tab">Location</a></li>
            <li role="presentation"><a href="#partecipants-{{ $slot->id }}" role="tab" data-toggle="tab">Partecipanti</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="contents-{{ $slot->id }}">
                <br/>
                {!! BootForm::open(['model' => $slot, 'update' => 'SlotController@update', 'class' => 'async-form']) !!}
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="artist">Artisti</label>
                            <textarea name="artist" class="form-control">{{ $slot->artist }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="contents">Programma</label>
                            <textarea name="contents" class="form-control" rows="10">{{ $slot->contents }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-default">Salva</button>
                        <button class="btn btn-danger void-me">Annulla Concerto</button>
                    </div>
                {!! BootForm::close() !!}
            </div>
            <div role="tabpanel" class="tab-pane" id="location-{{ $slot->id }}">
                <br/>
                {!! BootForm::open(['model' => $slot, 'update' => 'SlotController@update', 'class' => 'async-form', 'left_column_class' => 'col-md-5', 'left_column_offset_class' => 'col-md-offset-5', 'right_column_class' => 'col-md-7']) !!}
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <select multiple class="form-control" size="15" name="location">
                                @foreach(App\Adoption::where('status', 'confirmed')->orderBy('surname', 'asc')->get() as $location)
                                    <option value="{{ $location->id }}" {{ $slot->location->id == $location->id ? 'selected' : '' }}>{{ $location->name }} {{ $location->surname }} ({{ $location->capacity }} posti)</option>
                                @endforeach
                            </select>
                            <br/>
                        </div>
                        <div class="col-md-6 location-info">
                            {!! BootForm::staticField('name', 'Nome', $slot->location->name . ' ' . $slot->location->surname) !!}
                            {!! BootForm::staticField('address', 'Indirizzo', $slot->location->address) !!}
                            {!! BootForm::staticField('capacity', 'Posti', $slot->location->capacity) !!}
                            {!! BootForm::staticField('phone', 'Telefono', $slot->location->phone) !!}
                            {!! BootForm::staticField('email', 'E-Mail', $slot->location->email) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-default">Salva</button>
                    </div>
                {!! BootForm::close() !!}
            </div>
            <div role="tabpanel" class="tab-pane" id="partecipants-{{ $slot->id }}">
                <br/>
                @if($slot->bookings->isEmpty())
                    <div class="col-md-12">
                        <p class="alert alert-warning">
                            Non ci sono utenti prenotati
                        </p>
                    </div>
                @else
                    <div class="col-md-12">
                        <table class="table attendees">
                            <thead>
                                <tr>
                                    <th>Nome e Cognome</th>
                                    <th>Mail</th>
                                    <th>Telefono</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($slot->bookings as $booking)
                                    @foreach($booking->attendees as $attendee)
                                        @include('event.attendee', ['attendee' => $attendee])
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <button class="btn btn-default" data-toggle="modal" data-target="#new-attendee-{{ $slot->id }}">Aggiungi</button>
                        <button class="btn btn-default" data-toggle="modal" data-target="#send-mail-{{ $slot->id }}">Invia Mail</button>
                        <button class="btn btn-default">Stampa</button>
                    </div>

                    <div class="modal fade" id="new-attendee-{{ $slot->id }}" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Aggiungi Partecipante</h4>
                                </div>

                                {!! BootForm::open(['action' => 'BookingController@addAttendee', 'class' => 'form-horizontal add-attendee']) !!}
                                    <div class="modal-body">
                                        {!! csrf_field() !!}
                                        {!! BootForm::hidden('slot_id', $slot->id) !!}
                                        {!! BootForm::text('name', 'Nome') !!}
                                        {!! BootForm::text('surname', 'Cognome') !!}
                                        {!! BootForm::text('phone', 'Telefono') !!}
                                        {!! BootForm::email() !!}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                        <button type="submit" class="btn btn-primary">Salva</button>
                                    </div>
                                {!! BootForm::close() !!}
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="send-mail-{{ $slot->id }}" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Invia Mail ai Partecipanti</h4>
                                </div>

                                {!! BootForm::open(['action' => 'SlotController@sendMail']) !!}
                                    <div class="modal-body">
                                        {!! csrf_field() !!}
                                        {!! BootForm::hidden('slot_id', $slot->id) !!}
                                        {!! BootForm::radios('mail-type', 'Tipo', [
                                            'voided' => 'Evento annullato',
                                            'confirm' => 'Evento confermato',
                                            'custom' => 'Testo personalizzato (compila il testo sotto)',
                                        ]) !!}
                                        {!! BootForm::text('manual_subject', 'Oggetto', '', ['disabled' => 'disabled']) !!}
                                        {!! BootForm::textarea('manual_body', 'Testo', '', ['disabled' => 'disabled']) !!}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                        <button type="submit" class="btn btn-primary">Invia</button>
                                    </div>
                                {!! BootForm::close() !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
