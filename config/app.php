<?php

return [
    'providers' => [
        \Jakmall\Recruitment\Calculator\History\CommandHistoryServiceProvider::class,
    ],
    'available_drivers' => [
        'file' => [
            'path' => 'storage/mesinhitung.log'
        ],
        'latest' => [
            'path' => 'storage/latest.log'
        ],
        'composite' => [
            'path' => false
        ]
    ]
];
