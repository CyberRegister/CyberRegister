<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cyberregister</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
<div id="page">
    <div class="header">
        <img src="static/logohome.png" width="610">
    </div>
    <div id="payoff">Cyberregister</div>
    <nav class="navbar navbar-light bg-light navbar-expand-md" role="navigation">
        <div class="container">
            <ul class="nav navbar-nav ml-auto">
                @if (Route::has('login'))
                    @auth
                    <li class="nav-item"><a href="{{ url('/home') }}" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="/users" class="nav-link">Cyber Experts</a>
                    @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                    <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                    @endauth
                @endif
            </ul>
        </div>
    </nav>
    <div class="content">
        <div class="container">
            <p>Iets met inhoud . .</p>
            <p>Bekijk de code op <a href="https://github.com/CyberRegister/CyberRegister">GitHub</a>.</p>
        </div>
        <div class="footer">
            <img src="static/footerlogo.png" width="610">
        </div>
    </div>
</div>
</body>
</html>