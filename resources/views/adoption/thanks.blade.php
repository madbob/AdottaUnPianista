@extends('layouts.single')

@section('title', 'Grazie!')

@section('single_content')
    <div class="row">
        <div class="col-md-12">
            <div class="generic-button-large">
                <span>Grazie per la tua adesione!</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <p>
                Verrai prossimamente contattato per maggiori informazioni.
            </p>

            <p class="text-center">
                <a href="{{ url('/') }}" class="btn generic-button">Torna alla homepage</a>
            </p>
        </div>
    </div>
@endsection
