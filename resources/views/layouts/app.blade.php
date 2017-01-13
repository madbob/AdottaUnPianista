<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=IM+Fell+Great+Primer|Rubik" rel="stylesheet">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link href="/css/app.css" rel="stylesheet">
        <link href="/css/bootstrap-datepicker3.min.css" rel="stylesheet">
        <link href="/css/mine.css" rel="stylesheet">

        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
    </head>

    <body>
        <div id="app">
            <div class="container-fluid">
                @if(Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                @endif

                @yield('content')
            </div>
        </div>

        <script type="application/javascript" src="/js/app.js"></script>
        <script type="application/javascript" src="/js/bootstrap-datepicker.min.js"></script>
        <script type="application/javascript" src="/js/bootstrap-datepicker.it.min.js"></script>
        <script type="application/javascript" src="/js/mine.js"></script>
    </body>
</html>
