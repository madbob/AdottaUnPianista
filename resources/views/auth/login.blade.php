@extends('layouts.single')

@section('single_content')
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    {!! BootForm::open(['left_column_class' => 'col-md-4', 'right_column_class' => 'col-md-8']) !!}
                        {!! BootForm::hidden('remember', 1) !!}
                        {!! BootForm::email() !!}
                        {!! BootForm::password('password') !!}
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn generic-button">Login</button>
                                <a class="btn btn-link" href="{{ url('/password/reset') }}">Password Dimenticata?</a>
                            </div>
                        </div>
                    {!! BootForm::close() !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Registrati</div>
                <div class="panel-body">
                    {!! BootForm::open(['left_column_class' => 'col-md-4', 'left_column_offset_class' => 'col-md-offset-4', 'right_column_class' => 'col-md-8', 'action' => 'Auth\RegisterController@register']) !!}
                        {!! BootForm::text('name', 'Nome') !!}
                        {!! BootForm::text('surname', 'Cognome') !!}
                        {!! BootForm::email() !!}
                        {!! BootForm::text('phone', 'Telefono') !!}
                        {!! BootForm::password('password') !!}
                        {!! BootForm::password('password_confirmation', 'Conferma Password') !!}
                        {!! BootForm::submit('Registrati', ['class' => 'btn generic-button']) !!}
                    {!! BootForm::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
