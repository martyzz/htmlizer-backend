<?php

use Slim\Http\Request;
use Slim\Http\Response;

require 'handlers/postCreateHandler.php';
require 'handlers/putUpdateHandler.php';
require 'handlers/getReadHandler.php';

$app->group('/api', function () {

    // responds with identifier for created branches
    $this->post('/create', function (Request $request, Response $response, array $args) {
        return postCreateHandler($this, $request, $response, $args);
    });

    // responds with version for updated branches
    $this->put('/update/{identifier}', function (Request $request, Response $response, array $args) {
        return putUpdateHandler($this, $request, $response, $args);
    });

    // responds with branches for identifier (and version)
    $this->get('/read/{identifier}[/{version}]', function (Request $request, Response $response, array $args) {
        return getReadHandler($this, $request, $response, $args);
    });
});

// Catch-all route to serve a 404 Not Found page if none of the routes match
// NOTE: make sure this route is defined last
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
    return $handler($req, $res);
});