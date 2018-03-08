<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Cyberregister') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('static/icons/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('static/icons/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('static/icons/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('static/icons/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('static/icons/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('static/icons/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('static/icons/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('static/icons/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('static/icons/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('static/icons/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('static/icons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('static/icons/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('static/icons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('static/icons/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
</head>
<body>
    <div id="page">
        <div class="header">
            <img src="/static/logohome.png" width="610">
        </div>
        <div id="payoff">Cyberregister</div>
        <nav class="navbar navbar-light bg-light navbar-expand-md"
             role="navigation">
            <div class="container">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item"><a href="{{ url('/over') }}" class="nav-link">Wat is het</a></li>
                            @auth
                            <li><a class="nav-link" href="{{ route('users.index') }}">Cyber Experts</a></li>
                            <li><a class="nav-link" href="{{ route('cyberExpertise.index') }}">Cyber Expertises</a></li>
                            @if(Auth::user()->is_controller)
                            <li><a class="nav-link" href="{{ route('expertise.index') }}">Expertises</a></li>
                            <li><a class="nav-link" href="{{ route('pcePoint.index') }}">PCE punten</a></li>
                            @endif
                            @endauth
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                            <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Cyber</a></li>
                            <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                            @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('users.edit', ['cyber_code' => Auth::user()->cyber_code]) }}" id="user-edit">Profiel bewerken</a>
                                    @if(is_null(Auth::user()->u2fKey))
                                    <a class="dropdown-item" href="{{ route('u2f.register') }}" id="u2f-register">U2F toevoegen</a>
                                    @endif
                                    @if(is_null(Auth::user()->twoFAKey))
                                    <a class="dropdown-item" href="{{ route('2fa') }}" id="2fa-register">2FA toevoegen</a>
                                    @else
                                    <a class="dropdown-item" href="{{ route('2fa') }}" id="2fa-edit">2FA aanpassen</a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}" id="logout">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
            <div id="confirm-delete" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            Are you sure you want to delete this?
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-danger" id="delete">Delete</button>
                            <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <main class="py-4">
                @yield('content')
            </main>
        <div class="footer">
            <img src="/static/footerlogo.png" width="610">
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('script')
</body>
</html>
