@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Cyberregister</h2>
    <p>
        Het register bestaat uit experts op verscheidene gebieden van cyber die allen beschikken over en hoge mate van cyberbewustzijn.<br>
        Middels het cyberregister zijn cybercompetenties inzichtelijk, om te helpen bij het zoeken naar de juiste experts om cyberweerbaarheids processen te begeleiden.
    </p>
    <form method="POST" action="{{ route('expert.search') }}" class="search">
        @csrf
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
        Er zijn de afgelopen maand reeds {{ \App\User::where('created_at', '<', Carbon\Carbon::now()->subMonth())->count() }} nieuwe experts ingeschreven.
    </p>
    <p>Bekijk de code op <a href="https://github.com/CyberRegister/CyberRegister">GitHub</a>.</p>
</div>
@endsection
