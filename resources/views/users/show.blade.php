@extends('layouts.app')

@section('head')
<script type="application/ld+json" @cspNonce>{!! json_encode(\App\Support\ExpertSchema::forExpert($user), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endsection

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
                    @if($user->expertises->contains->isValid)
                        <span class="badge badge-success" title="Geldige registratie">&check; geregistreerd</span>
                    @else
                        <span class="badge badge-secondary" title="Geen geldige registratie">geen geldige registratie</span>
                    @endif
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(!is_null($user->expertises))
                    <table width="100%">
                    @foreach($user->expertises->sortBy('cyber_expertise_id') as $expertise)
                        <tr>
                            <td>
                                @if($expertise->isValid)
                                    <span class="text-success" title="Geldig">&check;</span>
                                @else
                                    <span class="text-muted" title="Verlopen">&times;</span>
                                @endif
                                {{ $expertise->code }}
                            </td>
                            <td>{{ $expertise->description }}</td>
                            <td>@if($expertise->date_of_expiration){{ $expertise->isValid ? 'geldig tot' : 'verlopen op' }} {{ $expertise->date_of_expiration->format('Y-m-d') }}@endif</td>
                        </tr>
                    @endforeach
                    </table>
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
