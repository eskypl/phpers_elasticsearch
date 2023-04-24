<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Elastic\Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()
    ->setHosts(['elasticsearch:9200'])
    ->build();

$response = $client->info();

echo $response['version']['number'] . PHP_EOL;
