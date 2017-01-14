@extends('layouts.single')

@section('title', 'Candida Location')

@section('single_content')
    <div class="row">
        <div class="col-md-12">
            <div class="generic-text">
                <p>
                    Hai un pianoforte in casa e abiti a San Salvario, San Donato, Barriera di Milano, Aurora Porta Palazzo o Mirafiori nord? Ti piacerebbe ospitare gratuitamente un concerto in casa tua? Consulta il calendario!<br/>
                    Stiamo cercando te: registrati qui o scrivi alla mail <a href="mailto:adottaunpianista@gmail.com">adottaunpianista@gmail.com</a>.
                </p>

                <p>
                    Registrandosi nella sezione Vorrei ospitare un concerto ci si può candidare ad accogliere un concerto in casa propria.
                </p>

                <p>
                    Al momento della selezione verrai contattato dal nostro staff.
                </p>

                <p>
                    L'organizzazione allestisce 10 concerti in 10 location diverse nell'arco di un weekend. Il rapporto tra residenti e pubblico è gestito nel massimo rispetto della privacy di ciascuno. L'organizzazione si fa carico di tutti gli oneri SIAE/Enpals, mentre al padrone di casa viene riconosciuta una accordatura gratuita dello strumento messo a disposizione.
                </p>

                <p>
                    Hai dei dubbi? Scrivi ad <a href="mailto:adottaunpianista@gmail.com">adottaunpianista@gmail.com</a>
                </p>
            </div>

            <br/>
        </div>

        <div class="col-md-12">
            {!! BootForm::open(['model' => $location, 'store' => 'AdoptionController@store', 'update' => 'AdoptionController@update']) !!}
                {!! BootForm::text('name', 'Nome') !!}
                {!! BootForm::text('surname', 'Cognome') !!}
                {!! BootForm::text('address', 'Indirizzo') !!}
                {!! BootForm::text('phone', 'Telefono') !!}
                {!! BootForm::email() !!}
                {!! BootForm::textarea('notes', 'Note') !!}
                {!! BootForm::submit('Invia Candidatura', ['class' => 'btn generic-button']) !!}
            {!! BootForm::close() !!}
        </div>
    </div>
@endsection
