@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-lg-12">
            <div class="login-panel card">
                <div class="card-header">
                    <h1 class="card-title">{{ trans('u2f::messages.auth.title') }}</h1>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger" role="alert" id="error"></div>
                    <div class="alert alert-success" role="alert" id="success">{{ trans('u2f::messages.success') }}</div>
                    <div align="center">
                        <img src="{{ asset('static/Challenge_2SV-Gnubby_graphic.png') }}"
                             alt="">
                    </div>
                    <h3>

                        {{ trans('u2f::messages.insertKey') }}

                    </h3>
                    <p>{{ trans('u2f::messages.buttonAdvise') }}
                        <br>{{ trans('u2f::messages.noButtonAdvise') }}</p>
                </div>
            </div>
        </div>
    </div>
<form method="POST" action="{{ route('u2f.auth') }}" id="form">
    @csrf
    <input type="hidden" name="authentication" id="authentication" value="" />
</form>
@endsection

@section('script')
<script type="text/javascript" nonce="{{ cspNonce() }}">
        var req = {!! json_encode($authenticationData) !!};

        var errors = {
            1: "{{ trans('u2f::errors.other_error') }}",
            2: "{{ trans('u2f::errors.bad_request') }}",
            3: "{{ trans('u2f::errors.configuration_unsupported') }}",
            4: "{{ trans('u2f::errors.device_ineligible') }}",
            5: "{{ trans('u2f::errors.timeout') }}"
        };

        u2fClient.login(req, errors);
</script>
@endsection
