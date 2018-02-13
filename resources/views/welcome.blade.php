<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cyber Register</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="page">
            <div class="header" style="text-align: center;">
                <img src="static/logohome.png" width="610" />
            </div>
            <div id="payoff">Cyber Register</div>
            <nav class="navbar navbar-default" role="navigation" style="margin-top: 300px; border-top: 0;">
                <div class="container">
                    <div class="navbar-header">
                        <!--<a class="navbar-brand" href="#">Meldpunt voor cyber</a> -->
                        <ul class="nav navbar-nav navbar-right">
                            @if (Route::has('login'))
                                @auth
                                    <li><a href="{{ url('/home') }}">Home</a></li>
                                @else
                                    <li><a href="{{ route('login') }}">Login</a></li>
                                    <li><a href="{{ route('register') }}">Register</a></li>
                                @endauth
                            @endif
                        </ul>
                    </div>
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="/">Home</a></li>
                        @auth
                        <li><a href="/users">Cyber Experts</a></li>
                        @endauth
                    </ul>
                </div>
            </nav>
            <div class="content">

                <div class="container">
                    Iets met inhoud
                </div>


            <div class="footer" style="text-align: center;">
                <img src="static/footerlogo.png" width="610" />
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
