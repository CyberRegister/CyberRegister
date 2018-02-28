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
            <p>Lorem ipsum dolor amet asymmetrical dreamcatcher seitan, retro chartreuse farm-to-table wolf viral edison
                bulb yr snackwave gochujang pickled umami. Hot chicken bespoke food truck, cold-pressed listicle
                single-origin coffee typewriter sartorial viral blog. Hoodie fanny pack put a bird on it forage.<br>
                Shoreditch letterpress you probably haven't heard of them keytar. Sartorial narwhal thundercats
                meggings tote bag trust fund put a bird on it pabst. Activated charcoal art party lumbersexual, before
                they sold out put a bird on it fashion axe pug +1 narwhal iceland.
            </p><p>
                Truffaut subway tile godard gastropub, green juice cloud bread authentic tumblr. Roof party disrupt
                single-origin coffee enamel pin narwhal tofu yuccie fixie pabst you probably haven't heard of them
                la croix. Mlkshk 8-bit unicorn YOLO, occupy neutra narwhal enamel pin pok pok letterpress affogato.<br>
                Man braid flexitarian fixie edison bulb chartreuse vaporware green juice, snackwave readymade forage
                chicharrones. Craft beer keytar selvage, man braid pug fixie plaid banh mi meditation gluten-free
                iceland hot chicken next level edison bulb vaporware. Locavore shabby chic everyday carry, williamsburg
                shaman artisan keffiyeh cliche.
            </p><p>
                Adaptogen pabst gentrify hoodie. Typewriter photo booth copper mug viral crucifix synth.<br>
                Ennui marfa cliche DIY, messenger bag mumblecore snackwave banjo chia cronut slow-carb tumblr
                shabby chic. Swag portland crucifix kombucha edison bulb. Cray shaman direct trade chartreuse,
                cold-pressed hammock tousled.
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