@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>Twee-factorenauthenticatie</strong>
                    </div>
                    <div class="card-body">
                        <p>Twee-factorenauthenticatie (2FA) versterkt de toegangsbeveiliging door
                            twee methoden (ook wel factoren genoemd) te vragen om uw identiteit te
                            verifi&#xEB;ren. Twee-factor-authenticatie beschermt tegen phishing, social
                            engineering en wachtwoord brute force-aanvallen en beveiligt uw logins
                            tegen aanvallers die zwakke of gestolen inloggegevens misbruiken.</p>
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(is_null($data['user']->twoFAKey))
                            <p>Als u twee-factorenauthenticatie voor uw account wilt inschakelen, dient
                                u de volgende stappen uit te voeren</p>
                            <strong>
                                <ol>
                                    <li>Durk op de onderstaande knop om een QR code te genereren, scan deze met uw app</li>
                                    <li>Voor de OTP code die uw app genereerd in</li>
                                </ol>
                            </strong>
                            <form class="" method="POST" action="{{ route('generate2faSecret') }}">
                                @csrf
                                <div class="form-group">
                                    <div class="col-lg-6 offset-md-">
                                        <button type="submit" class="btn btn-primary">Genereer geheime sleutel om 2FA in te schakelen</button>
                                    </div>
                                </div>
                            </form>
                        @elseif(!$data['user']->twoFAKey->google2fa_enable)
                            <strong>1. Scan deze QR code met uw app:</strong>
                            <br>
                            <img src="{{$data['google2fa_url'] }}" alt="">
                            <br>
                            <br> <strong>2. Voer de gegenereerde OTP code in om 2FA in te schakelen</strong>
                            <br>
                            <br>
                            <form class="" method="POST" action="{{ route('enable2fa') }}">
                                @csrf
                                <div class="form-group{{ $errors->has('verify-code') ? ' has-error' : '' }}">
                                    <label for="verify-code" class="col-lg-4 form-control-label">Authenticator Code</label>
                                    <div class="col-lg-6">
                                        <input id="verify-code" type="number" class="form-control" name="verify-code" required>
                                        @if ($errors->has('verify-code'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('verify-code') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-6 offset-md-">
                                        <button type="submit" class="btn btn-primary">2FA Inschakelen</button>
                                    </div>
                                </div>
                            </form>
                        @elseif($data['user']->twoFAKey->google2fa_enable)
                            <div class="alert alert-success">2FA is momenteel <strong>ingeschakeld</strong> voor uw account.</div>
                            <p>Wanneer u twee-factorenauthenticatie uit wenst te schakelen. Bevestig
                                uw wachtwoord en klik op de 2FA uitschakelen knop.</p>
                            <form class="" method="POST" action="{{ route('disable2fa') }}">
                                @csrf
                                <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                    <label for="current-password" class="col-lg-4 form-control-label">Huidige wachtwoord</label>
                                    <div class="col-lg-6">
                                        <input id="current-password" type="password" class="form-control" name="current-password" autocomplete="current-password" required>
                                        @if ($errors->has('current-password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('current-password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 offset-md-">
                                    <button type="submit" class="btn btn-primary ">2FA uitschakelen</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection