<?php

return [
    'errors' => [
        'other_error'               => 'An error occurred.',
        'bad_request'               => 'The visited URL doesn’t match the App ID or your are tot using HTTPS',
        'configuration_unsupported' => 'Client configuration is not supported.',
        'device_ineligible'         => 'The presented device is not eligible for this request. For a registration request this may mean that the token is already registered, and for a sign request it may mean that the token does not know the presented key handle.',
        'timeout'                   => 'Timeout reached before request could be satisfied.',
    ],
    'messages' => [
        'buttonAdvise'   => 'If your security key has a button, press it.',
        'noButtonAdvise' => 'If it does not, remove it and insert it again.',
        'success'        => 'Your key is detected and validated.',
        'insertKey'      => 'Insert your security key.',

        'auth' => [
            'title' => 'Authentication in two steps',
        ],

        'register' => [
            'title' => 'Register a new security key',
        ],
    ],
];
