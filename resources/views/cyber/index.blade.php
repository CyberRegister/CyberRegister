@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Cyber Expertises</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ul>
                    @forelse($cyberExpertises as $cyberExpertise)
                            @if(Auth::user()->can('edit', $cyberExpertise))
                            <li>
                                <a href="{{ route('cyberExpertise.edit', ['expertise_code' => $cyberExpertise->expertise_code]) }}">
                                    {{ $cyberExpertise->description }}
                                </a>
                            </li>
                            @else
                            <li>
                                <a href="{{ route('cyberExpertise.show', ['expertise_code' => $cyberExpertise->expertise_code]) }}">
                                    {{ $cyberExpertise->description }}
                                </a>
                            </li>
                            @endif
                    @empty
                        <li>Niets gevonden</li>
                    @endforelse
                    </ul>
                    <a href="{{ route('cyberExpertise.create') }}" class="btn btn-primary">Toevoegen</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
