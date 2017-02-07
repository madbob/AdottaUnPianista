@extends('layouts.single')

@section('title', 'Candida Location')

@section('single_content')
    <div class="row">
        <div class="col-md-12">
            <div class="generic-button-large">
                <span>VUOI OSPITARE UN CONCERTO A CASA TUA?</span>
            </div>
        </div>
    </div>
    <div class="row adoption">
        <div class="col-md-6 description-text">
            <div>
                <p>
                    Hai un pianoforte in casa e abiti a San Salvario, San Donato, Barriera di Milano, Aurora Porta Palazzo o Mirafiori nord? Ti piacerebbe ospitare gratuitamente un concerto in casa tua? Consulta il calendario!<br/>
                    Stiamo cercando te: registrati qui o scrivi alla mail <a href="mailto:adottaunpianista@gmail.com">adottaunpianista@gmail.com</a>.
                </p>

                <p class="separator"></p>

                <p>
                    Registrandosi nella sezione Vorrei ospitare un concerto ci si può candidare ad accogliere un concerto in casa propria.<br/>
                    Al momento della selezione verrai contattato dal nostro staff.<br/>
                    L'organizzazione allestisce 10 concerti in 10 location diverse nell'arco di un weekend. Il rapporto tra residenti e pubblico è gestito nel massimo rispetto della privacy di ciascuno. L'organizzazione si fa carico di tutti gli oneri SIAE/Enpals, mentre al padrone di casa viene riconosciuta una accordatura gratuita dello strumento messo a disposizione.
                </p>

                <p class="separator"></p>

                <p>
                    Hai dei dubbi? Scrivi ad <a href="mailto:adottaunpianista@gmail.com">adottaunpianista@gmail.com</a>
                </p>
            </div>
        </div>

        <div class="col-md-6">
            <form method="POST" action="{{ url('adozione') }}">
                {!! csrf_field() !!}
                <input type="text" name="name" placeholder="nome">
                <input type="text" name="surname" placeholder="cognome">
                <input type="text" name="address" placeholder="indirizzo">
                <input type="text" name="phone" placeholder="telefono">
                <input type="text" name="email" placeholder="email">
                <textarea rows="5" name="name" placeholder="note"></textarea>
                <button type="submit" class="btn generic-button">Invia candidatura</button>
            </form>
        </div>
    </div>
@endsection
