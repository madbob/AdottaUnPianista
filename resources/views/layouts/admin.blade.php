<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link href="/css/app.css" rel="stylesheet">
        <link href="/css/bootstrap-datepicker3.min.css" rel="stylesheet">
        <link href="/css/dropzone.css" rel="stylesheet">
        <link href="/css/mine.css" rel="stylesheet">

        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
    </head>

    <body>
        <div id="app">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <ul class="nav navbar-nav">
                            &nbsp;
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            @if (Auth::guest())
                                <li><a href="{{ url('/login') }}">Login</a></li>
                            @else
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        @if(Auth::user()->admin == true)
                                            <li><a href="{{ url('/evento') }}">Amministrazione</a></li>
                                        @endif

                                        <li>
                                            <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container">
                @if(Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                @endif

                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                <li><a href="{{ url('user') }}">Iscritti</a></li>
                                <li><a href="{{ url('evento') }}">Eventi</a></li>
                                <li><a href="{{ url('adozione') }}">Locations</a></li>
                                <li><a href="{{ url('archivio') }}">Archivio Mail</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>

                @yield('acontent')
            </div>
        </div>

        <script type="application/javascript" src="/js/app.js"></script>
        <script type="application/javascript" src="/js/bootstrap-datepicker.min.js"></script>
        <script type="application/javascript" src="/js/bootstrap-datepicker.it.min.js"></script>
        <script type="application/javascript" src="/js/dropzone.js"></script>
        <script type="application/javascript" src="/js/mine.js"></script>
    </body>
</html>
