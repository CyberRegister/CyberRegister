<?php

return [
    'errors' => [
        'other_error'               => 'Er ging iets mis.',
        'bad_request'               => 'De URL klopt niet met de App ID of je gebruikt geen HTTPS',
        'configuration_unsupported' => 'Client configuratie is niet ondersteund.',
        'device_ineligible'         => 'De token is niet gewaarboorgd voor deze aanvraag. Voor een registratieverzoek kan dit betekenen dat het token al is geregistreerd en voor een tekenaanvraag kan het betekenen dat het token de gepresenteerde toetshandgreep niet kent.',
        'timeout'                   => 'Timeout bereikt voordat aan het verzoek kon worden voldaan.',
    ],
    'messages' => [
        'buttonAdvise'   => 'Als uw beveiligingssleutel een knop heeft, drukt u erop.',
        'noButtonAdvise' => 'Als dat niet het geval is, verwijdert u het en plaatst u het opnieuw.',
        'success'        => 'Uw sleutel is gedetecteerd en gevalideerd.',
        'insertKey'      => 'Voer uw beveiligingssleutel in.',

        'auth' => [
            'title' => 'Authenticatie in twee stappen',
        ],

        'register' => [
            'title' => 'Registreer een nieuwe beveiligingssleutel',
        ],
    ],
];
