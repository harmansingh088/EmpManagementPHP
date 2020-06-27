<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require './vendor/autoload.php';
require './db.php';

$app = new \Slim\App;

$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Hello, Welcome to HomePage");
    return $response;
});


require './routes.php';

$app->run();
