@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">
                    Cyberexpert bewerken
                    <span class="float-right">
                        <form method="POST" action="{{ route('users.destroy', ['user' => $user->cyber_code]) }}">
                            <input type="hidden" name="_method" value="delete" />
                            @csrf
                            <button class="btn btn-danger btn-xs" name="delete-resource" type="submit" value="delete">delete</button>
                        </form>
                    </span>
                </div>

                {{ implode(' ', $errors->all()) }}

                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', ['user' => $user->cyber_code]) }}" class="dropzone" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="patch" />
                        @csrf
                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">Naam</label>

                            <div class="col-md-3">
                                <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ $user->first_name }}" placeholder="Voornaam" autocomplete="given-name" required autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-2">
                                <input id="middle_name" type="text" class="form-control{{ $errors->has('middle_name') ? ' is-invalid' : '' }}" name="middle_name" value="{{ $user->middle_name }}" placeholder="Tussenvoegsel" autocomplete="additional-name">

                                @if ($errors->has('middle_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('middle_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ $user->last_name }}" placeholder="Achternaam" autocomplete="family-name" required>

                                @if ($errors->has('last_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cyber_code" class="col-md-4 col-form-label text-md-right">Cybercode</label>

                            <div class="col-md-2">
                                <input id="cyber_code" type="texts" class="form-control{{ $errors->has('cyber_code') ? ' is-invalid' : '' }}" name="cyber_code" value="{{ $user->cyber_code }}" placeholder="CODE" autocomplete="username" required maxlength="6">

                                @if ($errors->has('cyber_code'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('cyber_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 col-form-label">
                                Je 6 karacter, alphanumerieke, publieke code.
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date_of_birth" class="col-md-4 col-form-label text-md-right">Geboortedetails</label>

                            <div class="col-md-4">
                                <input id="date_of_birth" type="date" class="form-control{{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}" name="date_of_birth" value="{{ $user->date_of_birth }}" autocomplete="bday" required>

                                @if ($errors->has('date_of_birth'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('date_of_birth') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <input id="place_of_birth" type="text" class="form-control{{ $errors->has('place_of_birth') ? ' is-invalid' : '' }}" name="place_of_birth" value="{{ $user->place_of_birth }}" placeholder="Geboorteplaats" required>

                                @if ($errors->has('place_of_birth'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('place_of_birth') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-mailadres</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}" autocomplete="email" placeholder="E-Mail" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Photo</label>

                            <div class="col-md-8 dz-message dz-default">
                                <h4>Sleur hier je pasfoto heen</h4>
                                <span>Of klik om het bestand te zoeken</span>
                                <div class="fallback">
                                    <input name="file" type="file" />
                                </div>
                            </div>

                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
