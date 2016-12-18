<tr data-attendee-id="{{ $attendee->id }}">
    <td>{{ $attendee->name }} {{ $attendee->surname }}</td>
    <td>{{ $attendee->real_mail }}</td>
    <td>{{ $attendee->real_phone }}</td>
    <td><button class="btn btn-danger remove-attendee"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td>
</tr>
