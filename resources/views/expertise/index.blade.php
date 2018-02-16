@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Expertises</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ul>
                    @forelse($expertises as $expertise)
                            @if(Auth::user()->can('edit', $expertise))
                            <li>
                                <a href="{{ route('expertise.edit', ['expertise_code' => $expertise->id]) }}">
                                    {{ $expertise->cyberExpertise->expertise_code }} {{ $expertise->user->name }}
                                </a>
                            </li>
                            @else
                            <li>
                                <a href="{{ route('expertise.show', ['expertise_code' => $expertise->id]) }}">
                                    {{ $expertise->cyberExpertise->expertise_code }} {{ $expertise->user->name }}
                                </a>
                            </li>
                            @endif
                    @empty
                        <li>Niets of niemand gevonden</li>
                    @endforelse
                    </ul>
                    <a href="{{ route('expertise.create') }}" class="btn btn-primary">Toevoegen</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
