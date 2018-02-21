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

                    <form method="POST" action="{{ route('users.search') }}" class="search">
                        @csrf
                        <div class="form-group row">
                            <label for="q" class="col-md-4 col-form-label text-md-right">Search</label>

                            <div class="col-md-8">
                                <input id="q" type="text" class="form-control" name="q" value="{{ $q }}" required>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>
                    <ul>
                    @forelse($users as $user)
                        <li>
                            @if(Auth::user()->can('edit', $user))
                            <a href="{{ route('users.edit', ['cyber_code' => $user->cyber_code]) }}">{{ $user->name }}</a>
                            @else
                            <a href="{{ route('users.show', ['cyber_code' => $user->cyber_code]) }}">{{ $user->name }}</a>
                            @endif
                        </li>
                    @empty
                        @if(!empty($q))
                        <li>Niemand gevonden</li>
                        @endif
                    @endforelse
                    </ul>
                    @if(Auth::user()->can('create', \App\User::class))
                    <a href="{{ route('users.create') }}" class="btn btn-primary">Toevoegen</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
