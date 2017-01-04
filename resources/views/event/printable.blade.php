<html>
    <body>
        <h3>Partecipanti concerto {{ $slot->printableDate() }} {{ $slot->printableHour() }}</h3>

        <hr/>

        <table border="1" style="width: 100%" cellpadding="5">
            <thead>
                <tr>
                    <th width="20%"><strong>Nome</strong></th>
                    <th width="20%"><strong>Cognome</strong></th>
                    <th width="20%"><strong>Telefono</strong></th>
                    <th width="40%"><strong>Note</strong></th>
                </tr>
            </thead>
            <tbody>
                @foreach($slot->bookings as $booking)
                    @foreach($booking->attendees as $attendee)
                        <tr>
                            <td width="20%">{{ $attendee->name }}</td>
                            <td width="20%">{{ $attendee->surname }}</td>
                            <td width="20%">{{ $attendee->real_phone }}</td>
                            <td width="40%">&nbsp;</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </body>
</html>
