<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()
    ->setHosts(['elasticsearch:9200'])
    ->build();

create_index($client);
insert_one($client);
insert_many($client);

function create_index(Client $client): void
{
    $params = [
        'index' => 'airports_php',
        'body' => [
            'mappings' => [
                'properties' => [
                    'code' => [
                        'type' => 'keyword'
                    ],
                    'name' => [
                        'type' => 'text'
                    ],
                    'city' => [
                        'type' => 'text'
                    ],
                    'country' => [
                        'type' => 'text'
                    ]
                ]
            ]
        ]
    ];

    $client->indices()->create($params);
}

function insert_one(Client $client): void
{
    $params = [
        'index' => 'airports_php',
        'body'  => [
            'code' => 'KTW',
            'name' => 'Pyrzowice',
            'city' => 'Katowice',
            'country' => 'Polska'
        ]
    ];

    $client->index($params);
}

function insert_many(Client $client): void
{
    $params = [];
    $airports = [
        [
            'code' => 'KRK',
            'name' => 'Balice',
            'city' => 'Kraków',
            'country' => 'Polska'
        ],
        [
            'code' => 'WMI',
            'name' => 'Modlin',
            'city' => 'Warszawa',
            'country' => 'Polska'
        ],
        [
            'code' => 'WAW',
            'name' => 'Okęcie',
            'city' => 'Warszawa',
            'country' => 'Polska'
        ],
        [
            'code' => 'WRO',
            'name' => 'Strachowice',
            'city' => 'Wrocław',
            'country' => 'Polska'
        ],
        [
            'code' => 'IEG',
            'name' => 'Babimost',
            'city' => 'Zielona Góra',
            'country' => 'Polska'
        ]
    ];

    foreach ($airports as $airport) {
        $params['body'][] = [
            'index' => [
                '_index' => 'airports_php',
            ]
        ];

        $params['body'][] = [
            'code' => $airport['code'],
            'name' => $airport['name'],
            'city' => $airport['city'],
            'country' => $airport['country']
        ];
    }

    $client->bulk($params);
}