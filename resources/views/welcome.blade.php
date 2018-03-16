@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Cyberregister</h2>
    <p>
        Het register bestaat uit experts op verscheidene gebieden van cyber die allen beschikken over en hoge mate van cyberbewustzijn.<br>
        Middels het cyberregister zijn cybercompetenties inzichtelijk, om te helpen bij het zoeken naar de juiste experts om cyberweerbaarheids processen te begeleiden.
    </p>
    <p>
        Een cyberexpert dient per twee jaar voldoende Permanente Cyber Expertise (PCE) punten te behalen, hoeveel punten daar voor nodig zijn hangt af van de geaccrediteerde cyberexpertises.<br>
        Alleen experts die voldoen aan de kwaliteitseisen die het Cyberregister stelt, staan in het Register ingeschreven.
    </p>
    <p>
        Er zijn de afgelopen maand reeds {{ \App\User::where('created_at', '<', Carbon\Carbon::now()->subMonth())->count() }} nieuwe experts ingeschreven.
    </p>
    <p>Bekijk de code op <a href="https://github.com/CyberRegister/CyberRegister">GitHub</a>.</p>
</div>
@endsection
