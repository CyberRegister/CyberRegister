@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">
                    PCE punten toevoegen
                </div>

                {{ implode(' ', $errors->all()) }}

                <div class="card-body">
                    <form method="POST" action="{{ route('pcePoint.store') }}" class="register">
                        @csrf

                        <div class="form-group row">
                            <label for="user_id" class="col-md-4 col-form-label text-md-right">Cyber Expert</label>

                            <div class="col-md-8">
                                <select id="user_id" class="form-control{{ $errors->has('user_id') ? ' is-invalid' : '' }}" name="user_id">
                                @foreach(App\User::all() as $user)
                                    <option value="{{ $user->id }}" @if($user->id === old('user_id'))selected="selected"@endif>{{ $user->name }}</option>
                                @endforeach
                                </select>
                                @if ($errors->has('user_id'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('user_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="location_code" class="col-md-4 col-form-label text-md-right">Locatie code + puntene</label>

                            <div class="col-md-4">
                                <input id="location_code" type="text" class="form-control{{ $errors->has('location_code') ? ' is-invalid' : '' }}" name="location_code" value="{{ old('location_code') }}" required maxlength="6">

                                @if ($errors->has('location_code'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('location_code') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <input id="points" type="number" class="form-control{{ $errors->has('points') ? ' is-invalid' : '' }}" name="points" value="{{ old('points') }}" required min="0">

                                @if ($errors->has('points'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('points') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Opslaan
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
