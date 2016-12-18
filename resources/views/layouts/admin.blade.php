@extends('layouts.app')

@section('content')
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('user') }}">Iscritti</a></li>
                    <li><a href="{{ url('evento') }}">Eventi</a></li>
                    <li><a href="{{ url('adozione') }}">Locations</a></li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('acontent')
@endsection
