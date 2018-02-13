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
                        <li><a href="{{ route('cyber.edit', ['expertise_code' => $cyberExpertise->expertise_code]) }}">{{ $cyberExpertise->description }}</a></li>
                    @empty
                        <li>Niets gevonden</li>
                    @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
