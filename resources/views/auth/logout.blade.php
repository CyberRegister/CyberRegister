@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Uitloggen</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-8">
                                <input type="submit" value="Logout">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
