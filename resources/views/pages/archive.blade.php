@extends('layouts.admin')

@section('title', 'Archivio Mail Inviate')

@section('acontent')
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th width="20%">Destinatari</th>
                        <th width="20%">Oggetto</th>
                        <th width="50%">Mail</th>
                        <th width="10%">Data</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $message)
                        <tr>
                            <td>{{ $message->context }}</td>
                            <td>{{ $message->subject }}</td>
                            <td>{{ nl2br($message->body) }}</td>
                            <td>{{ date('d/m/Y', strtotime($message->created_at)) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
