<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=IM+Fell+Great+Primer|Rubik" rel="stylesheet">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Adotta un Pianista') }}</title>

        <link href="/css/app.css" rel="stylesheet">
        <link href="/css/bootstrap-datepicker3.min.css" rel="stylesheet">
        <link href="/css/mine.css" rel="stylesheet">

        <meta property="og:site_name" content="Adotta un Pianista" />
        <meta property="og:title" content="Adotta un Pianista" />
        <meta property="og:url" content="{{ env('APP_URL') }}" />
        <meta property="og:image" content="{{ env('APP_URL') }}/images/fb.jpg" />
        <meta property="og:type" content="website" />
        <meta property="og:country-name" content="Italy" />
        <meta property="og:email" content="{{ env('MAIL_FROM_ADDRESS') }}" />
        <meta property="og:locale" content="it_IT" />

        <meta name="twitter:title" content="Adotta un Pianista" />
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:url" content="{{ env('APP_URL') }}" />

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

        <script type="text/javascript">
            var _paq = _paq || [];
            _paq.push(["setDomains", ["*.adottaunpianista.it"]]);
            _paq.push(['disableCookies']);
            _paq.push(['trackPageView']);
            _paq.push(['enableLinkTracking']);
            (function() {
                var u="//stats.madbob.org/";
                _paq.push(['setTrackerUrl', u+'piwik.php']);
                _paq.push(['setSiteId', '5']);
                var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
                g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
            })();
        </script>
        <noscript><p><img src="//stats.madbob.org/piwik.php?idsite=5" style="border:0;" alt="" /></p></noscript>
    </body>
</html>
