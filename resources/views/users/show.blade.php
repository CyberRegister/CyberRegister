@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Users</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    TODO: more than just {{ $user->name }}
                    @if(!is_null($user->expertises))
                    <ul>
                    @foreach($user->expertises as $expertise)
                        <li>{{ $expertise->code }}</li>
                    @endforeach
                    </ul>
                    @endif
                    @if(!empty($user->photo))
                        <img src="{{ $user->photo }}" alt="{{ $user->name }}" width="100%" />
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
