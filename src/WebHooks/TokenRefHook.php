<?php
/*public function index()
 {
     $promises = call_user_func(function () {
         foreach ($this->usernames as $username) {
             (yield $this->client->requestAsync('GET', 'https://api.github.com/users/' . $username));
         }
     });
     // Wait till all the requests are finished.
     \GuzzleHttp\Promise\all($promises)->then(function (array $responses) {
         $this->profiles = array_map(function ($response) {
             return json_decode($response->getBody(), true);
         }, $responses);
     })->wait();
     // Return JSON response
     $response = new Response();
     // StreamInterface objects are not immutable!
     $response->getBody()->write($this->html());
     return $response->withHeader('Content-type', 'text/html');
 }*/
 use GuzzleHttp\Pool;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

$client = new Client();

$requests = function ($total) {
    $uri = 'http://127.0.0.1:8126/guzzle-server/perf';
    for ($i = 0; $i < $total; $i++) {
        yield new Request('GET', $uri);
    }
};

$pool = new Pool($client, $requests(100), [
    'concurrency' => 5,
    'fulfilled' => function ($response, $index) {
        // this is delivered each successful response
    },
    'rejected' => function ($reason, $index) {
        // this is delivered each failed request
    },
]);

// Initiate the transfers and create a promise
$promise = $pool->promise();

// Force the pool of requests to complete.
$promise->wait();