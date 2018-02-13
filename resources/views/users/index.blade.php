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

                    <ul>
                    @forelse($users as $user)
                        <li>
                            @if(Auth::user()->can('edit', $user))
                            <a href="{{ route('users.edit', ['cyber_code' => $user->cyber_code]) }}">{{ $user->name }}</a>
                            @else
                            {{ $user->name }}
                            @endif
                        </li>
                    @empty
                        <li>Niemand gevonden</li>
                    @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
