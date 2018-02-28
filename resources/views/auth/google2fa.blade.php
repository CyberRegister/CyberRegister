@extends('layouts.app')

@section('content')<div class="container">
    <div class="row">
        <div class="col-lg-8 offset-md-">
            <div class="card">
                <div class="card-header">Twee-factorenauthenticatie</div>
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
                        <strong>Voer de OTP code vanuit uw app in</strong>
                    <br>
                    <br>
                    <form class="" action="{{ route('2faVerify') }}" method="POST">{{ csrf_field() }}
                        <div class="form-group{{ $errors->has('one_time_password-code') ? ' has-error' : '' }}">
                            <label for="one_time_password" class="col-lg-4 form-control-label">One Time Password</label>
                            <div class="col-lg-6">
                                <input name="one_time_password" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-6 offset-md-">
                                <button class="btn btn-primary" type="submit">Authenticeren</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
