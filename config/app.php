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
    ],
    'test_drivers' => [
        'file' => [
            'path' => 'storage/testmesinhitung.log'
        ],
        'latest' => [
            'path' => 'storage/testlatest.log'
        ],
        'composite' => [
            'path' => false
        ]
    ]
];
