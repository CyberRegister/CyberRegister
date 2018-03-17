@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">
                    <strong>{{ $user->name }}</strong>
                    @foreach($user->expertises->sortBy('cyber_expertise_id') as $expertise)
                        {{ $expertise->code }}
                    @endforeach
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(!is_null($user->expertises))
                    <ul>
                    @foreach($user->expertises->sortBy('cyber_expertise_id') as $expertise)
                        <li>{{ $expertise->code }} ( {{ $expertise->description }} ) @if($expertise->date_of_certification)geldig tot {{  $expertise->date_of_certification->format('Y-m-d') }}@endif</li>
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
