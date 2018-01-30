<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Container;

use Respect\Validation\Validator;

function postCreateHandler(Container $container, Request $request, Response $response, array $args) {
  $branches = $request->getParsedBodyParam('branches', null);

  if ($branches === null) {
    return $response->withJson([
      "message" => "Parameter 'branches' is required"
    ], 400);
  }

  if (!Validator::arrayType()->validate($branches)) {
    return $response->withJson([
      "message" => "Parameter 'branches' must be a valid JSON"
    ], 400);
  }

  $identifier = uniqid(true);
  $data = [ $branches ]; 
  $container->flintstone->set($identifier, $data);

  return $response->withJson([
    'identifier' => $identifier
  ], 200);
}