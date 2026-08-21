@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-lg-12">
        <div class="login-panel card">
            <div class="card-header">
                <h1 class="card-title">{{ trans('webauthn::messages.register.title') }}</h1>
            </div>
            <div class="card-body">
                <div class="alert alert-danger d-none" role="alert" id="error"></div>
                <div class="alert alert-success d-none" role="alert" id="success">{{ trans('webauthn::messages.success') }}</div>
                <div align="center">
                    <img src="{{ asset('static/Challenge_2SV-Gnubby_graphic.png') }}" alt="">
                </div>
                <h3>{{ trans('webauthn::messages.insertKey') }}</h3>
                <p>{{ trans('webauthn::messages.buttonAdvise') }}
                    <br>{{ trans('webauthn::messages.noButtonAdvise') }}</p>
                <form id="form">
                    <div class="form-group">
                        <label for="name">{{ trans('webauthn::messages.key_name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" value="key">
                    </div>
                    <button type="submit" class="btn btn-primary" id="submit">{{ trans('webauthn::messages.submit') }}</button>
                    <a href="{{ route('home') }}" class="btn btn-secondary">{{ trans('webauthn::messages.cancel') }}</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('vendor/webauthn/webauthn.js') }}" @cspNonce></script>
<script type="text/javascript" @cspNonce>
    (function () {
        var publicKey = {!! json_encode($publicKey) !!};
        var storeUrl = "{{ route('webauthn.store') }}";
        var token = document.querySelector('meta[name="csrf-token"]').content;

        var errors = {
            key_already_used: "{{ trans('webauthn::errors.key_already_used') }}",
            key_not_allowed: "{{ trans('webauthn::errors.key_not_allowed') }}",
            not_secured: "{{ trans('webauthn::errors.not_secured') }}",
            not_supported: "{{ trans('webauthn::errors.not_supported') }}"
        };

        function show(id, message) {
            var el = document.getElementById(id);
            if (message) {
                el.textContent = message;
            }
            el.classList.remove('d-none');
        }

        function errorMessage(name, message) {
            switch (name) {
                case 'InvalidStateError':
                    return errors.key_already_used;
                case 'NotAllowedError':
                    return errors.key_not_allowed;
                default:
                    return message;
            }
        }

        var webauthn = new WebAuthn(function (name, message) {
            show('error', errorMessage(name, message));
        });

        if (!webauthn.webAuthnSupport()) {
            show('error', webauthn.notSupportedMessage() === 'not_secured' ? errors.not_secured : errors.not_supported);
            document.getElementById('submit').disabled = true;
            return;
        }

        document.getElementById('form').addEventListener('submit', function (e) {
            e.preventDefault();
            webauthn.register(publicKey, function (data) {
                data.name = document.getElementById('name').value;
                fetch(storeUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify(data)
                }).then(function (response) {
                    return response.json();
                }).then(function (body) {
                    show('success');
                    if (body.callback) {
                        window.location.href = body.callback;
                    }
                }).catch(function (err) {
                    show('error', err.message);
                });
            });
        });
    })();
</script>
@endsection
