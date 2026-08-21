@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Cyberexperts</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="GET" action="{{ route('expert.search') }}" class="search">
                        <div class="form-group row">
                            <label for="q" class="col-md-4 col-form-label text-md-right">Zoeken</label>

                            <div class="col-md-8">
                                <input id="q" type="text" class="form-control" name="q" value="{{ $q }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sort" class="col-md-4 col-form-label text-md-right">Sorteren op</label>

                            <div class="col-md-4">
                                <select id="sort" name="sort" class="form-control">
                                    @foreach(array_keys(\App\Http\Controllers\UserController::SORTS) as $option)
                                        <option value="{{ $option }}" @selected($sort === $option)>{{ ucfirst($option) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select id="direction" name="direction" class="form-control">
                                    <option value="asc" @selected($direction === 'asc')>Oplopend</option>
                                    <option value="desc" @selected($direction === 'desc')>Aflopend</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Zoeken
                                </button>
                            </div>
                        </div>
                    </form>
                    @if($users->total() > 0)
                        <p class="text-muted">
                            {{ $users->total() }} {{ $users->total() === 1 ? 'expert' : 'experts' }} gevonden
                        </p>
                    @endif
                    <ul>
                    @forelse($users as $user)
                        <li>
                            @if(Auth::user() && Auth::user()->can('edit', $user))
                            <a href="{{ route('users.edit', ['user' => $user->cyber_code]) }}">{{ $user->name }}</a>
                            @else
                            <a href="{{ route('expert.show', ['user' => $user->cyber_code]) }}">{{ $user->name }}</a>
                            @endif
                        </li>
                    @empty
                        @if(!empty($q))
                        <li>Niemand gevonden</li>
                        @endif
                    @endforelse
                    </ul>
                    {{ $users->links() }}
                    @if(Auth::user() && Auth::user()->can('create', \App\Models\User::class))
                    <a href="{{ route('users.create') }}" class="btn btn-primary">Toevoegen</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
