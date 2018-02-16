@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">PCE Punten</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ul>
                    @forelse($pcePoints as $pcePoint)
                            @if(Auth::user()->can('edit', $pcePoint))
                            <li>
                                <a href="{{ route('pcePoint.edit', ['id' => $pcePoint->id]) }}">
                                    {{ $pcePoint->location_code }} {{ $pcePoint->user->name }}
                                </a>
                            </li>
                            @else
                            <li>
                                <a href="{{ route('pcePoint.show', ['id' => $pcePoint->id]) }}">
                                    {{ $pcePoint->location_code }} {{ $pcePoint->user->name }}
                                </a>
                            </li>
                            @endif
                    @empty
                        <li>Niets of niemand gevonden</li>
                    @endforelse
                    </ul>
                    <a href="{{ route('pcePoint.create') }}" class="btn btn-primary">Toevoegen</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
