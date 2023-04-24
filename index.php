<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Elastic\Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()
    ->setHosts(['elasticsearch:9200'])
    ->build();

if (!isset($_POST['phrase'])) {
    header('Content-type: application/json');
    echo json_encode([]);
    exit;
}

$searchPhrase = $_POST['phrase'];

$searchParams = [
    'index' => 'airports_php',
    'body'  => [
        'query' => [
            'bool' => [
                'should' => [
                    [
                        'term' => [
                            'code' => strtoupper($searchPhrase)
                        ],
                    ],
                    [
                        'match_phrase_prefix' => [
                            'name' => $searchPhrase
                        ],
                    ],
                    [
                        'match_phrase_prefix' => [
                            'city' => $searchPhrase
                        ],
                    ],
                    [
                        'match_phrase_prefix' => [
                            'country' => $searchPhrase
                        ],
                    ],
                    [
                        'multi_match' => [
                            'fields' => ['name', 'city', 'country'],
                            'query' => $searchPhrase,
                            'fuzziness' => 1
                        ]
                    ]
                ]
            ]
        ]
    ]
];

$response = $client->search($searchParams);

header('Content-type: application/json');
echo json_encode($response->asArray());