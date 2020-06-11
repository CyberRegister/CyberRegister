@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">
                    Expertise bewerken
                    <span class="float-right">
                        <form method="POST" action="{{ route('expertise.destroy', ['expertise' => $expertise->id]) }}">
                            <input type="hidden" name="_method" value="delete" />
                            @csrf
                            <button class="btn btn-danger btn-xs" name="delete-resource" type="submit" value="delete">delete</button>
                        </form>
                    </span>
                </div>

                {{ implode(' ', $errors->all()) }}

                <div class="card-body">
                    <form method="POST" action="{{ route('expertise.update', ['expertise' => $expertise->id]) }}" class="register">
                        <input type="hidden" name="_method" value="patch" />
                        @csrf

                        <div class="form-group row">
                            <label for="user_id" class="col-md-4 col-form-label text-md-right">Cyber Expert</label>

                            <div class="col-md-8">
                                <select id="user_id" class="form-control{{ $errors->has('user_id') ? ' is-invalid' : '' }}" name="user_id">
                                @foreach(App\User::all() as $user)
                                    <option value="{{ $user->id }}" @if($user->id === $expertise->user_id)selected="selected"@endif>{{ $user->name }}</option>
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
                            <label for="cyber_expertise_id" class="col-md-4 col-form-label text-md-right">Cyber Expertise</label>

                            <div class="col-md-8">
                                <select id="cyber_expertise_id" class="form-control{{ $errors->has('cyber_expertise_id') ? ' is-invalid' : '' }}" name="cyber_expertise_id">
                                    @foreach(App\CyberExpertise::all() as $cyberExpertise)
                                        <option value="{{ $cyberExpertise->id }}" @if($cyberExpertise->id === $expertise->cyber_expertise_id)selected="selected"@endif>{{ $cyberExpertise->expertise_code }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('cyber_expertise_id'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('cyber_expertise_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date_of_certification" class="col-md-4 col-form-label text-md-right">Van / Tot</label>

                            <div class="col-md-4">
                                <input id="date_of_certification" type="date" class="form-control{{ $errors->has('date_of_certification') ? ' is-invalid' : '' }}" name="date_of_certification" value="{{ $expertise->date_of_certification }}" required>

                                @if ($errors->has('date_of_certification'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('date_of_certification') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <input id="date_of_expiration" type="date" class="form-control{{ $errors->has('date_of_expiration') ? ' is-invalid' : '' }}" name="date_of_expiration" value="{{ $expertise->date_of_expiration }}" required>

                                @if ($errors->has('date_of_expiration'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('date_of_expiration') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="certification_code" class="col-md-4 col-form-label text-md-right">Certificatie code</label>

                            <div class="col-md-8">
                                <input id="certification_code" type="certification_code" class="form-control{{ $errors->has('certification_code') ? ' is-invalid' : '' }}" name="certification_code" value="{{ $expertise->certification_code }}" required>

                                @if ($errors->has('certification_code'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('certification_code') }}</strong>
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
