@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Cyberregister</h2>
    <p>
        Het cyberregister is een openbaar register van gecertificeerde cyberexperts. Deze professionals hebben daarvoor examens gedaan en houden de kennis bij via permanente educatie. In het register zijn alleen geldige expertises doorzoekbaar.
    </p>
    <p>
        Ter verificatie kunt u een expert ook vragen om zijn of haar cyberprofessional pas te identificatie. Daarnaast kunt u bij verificatie ook via het register met de expert mailen. Hiervoor kunt u een bericht sturen naar de door de expert genoemde [cybercode] @ cyberregister.nl.
    </p>
    <form method="GET" action="{{ route('expert.search') }}" class="search">
        <div class="form-group row">
            <label for="q" class="col-md-2 col-form-label text-md-right">Zoeken</label>

            <div class="col-md-6">
                <input id="q" type="text" class="form-control" name="q" value="{{ old('q') }}" required>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">
                    Zoeken
                </button>
            </div>
        </div>
    </form>
    <p>
        Een cyberexpert dient per twee jaar voldoende Permanente Cyber Expertise (PCE) punten te behalen, hoeveel punten daar voor nodig zijn hangt af van de geaccrediteerde cyberexpertises.<br>
        Alleen experts die voldoen aan de kwaliteitseisen die het Cyberregister stelt, staan in het Register ingeschreven.
    </p>
    <p>
        Om melding te maken van cybermisstanden verwijzen wij u naar het <a href="https://cybermeldpunt.nl/">Cybermeldpunt</a>, van daar uit kan de Cyberonderzoeksraad één of meerdere cyberexperts aanstellen om een cyberonderzoek in te stellen.<br>
        Er zijn de afgelopen maand reeds {{ \App\Models\User::where('created_at', '>=', Carbon\Carbon::now()->subMonth())->count() }} nieuwe experts ingeschreven.
    </p>
    <p>Bekijk de code op <a href="https://github.com/CyberRegister/CyberRegister">GitHub</a>.</p>
</div>
@endsection
