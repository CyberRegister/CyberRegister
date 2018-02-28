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
                    <li class="nav-item"><a href="{{ url('/over') }}" class="nav-link">Wat is het</a></li>
                    @auth
                    <li class="nav-item"><a href="{{ url('/home') }}" class="nav-link">Cyberregister</a></li>
                    <li class="nav-item"><a href="/users" class="nav-link">Cyber Experts</a>
                    @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Cyber</a></li>
                    <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                    @endauth
                @endif
            </ul>
        </div>
    </nav>
    <div class="content">
        <div class="container">
            <p>
                Lorem ipsum dolor amet organic readymade chillwave try-hard, trust fund iPhone ramps chia shaman
                meditation cloud bread affogato art party echo park lyft. Hammock mlkshk heirloom, affogato plaid
                single-origin coffee fingerstache roof party mumblecore. Heirloom echo park beard vice hella paleo
                enamel pin marfa. Ugh selfies before they sold out biodiesel air plant, tbh cronut lyft stumptown
                fixie scenester next level.
            </p>
            <p>
                Mede mogelijk gemaakt door:
                <ul>
                    <li>
                        <a href="https://dewinter.com/">De Winter Information Solutions</a> idee.
                    </li>
                    <li>
                        <a href="https://beehive42.org/">Beehive Techcampus 4.2</a> diensten.
                    </li>
                    <li>
                        <a href="https://sentry.io/">Sentry</a> monitoring.
                    </li>
                    <li>
                        <a href="https://scrutinizer-ci.com/">Scrutinizer</a> kwaliteitscontrole.
                    </li>
                </ul>
            </p>
            <p>Bekijk de code op <a href="https://github.com/CyberRegister/CyberRegister">GitHub</a>.</p>
        </div>
        <div class="footer">
            <img src="static/footerlogo.png" width="610">
        </div>
    </div>
</div>
</body>
</html>