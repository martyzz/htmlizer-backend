<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Container;

use Respect\Validation\Validator;

function putUpdateHandler(Container $container, Request $request, Response $response, array $args) {
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

  $identifier = $args['identifier'];
  $branchesContainer = $container->flintstone->get($identifier);

  if (!$branchesContainer) {
    return $response->withJson([
      "message" => "Value of parameter 'identifier' was not recognized"
    ], 404);
  }

  $branchesContainer[] = $branches;
  $version = count($branchesContainer);
  $container->flintstone->set($identifier, $branchesContainer);

  return $response->withJson([
    "version" => $version
  ], 200);
}