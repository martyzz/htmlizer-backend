<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Container;

function getReadHandler(Container $container, Request $request, Response $response, array $args) {
  $identifier = $args['identifier'];
  $version = isset($args['version']) ? $args['version'] : 1;
  $versionIndex = $version - 1;

  $branchesContainer = $container->flintstone->get($identifier);

  if (!$branchesContainer) {
    return $response->withJson([
      "message" => "Value of parameter 'identifier' was not recognized"
    ], 404);
  }

  if (!isset($branchesContainer[$versionIndex])) {
    return $response->withJson([
      "message" => "Value of parameter 'version' was not recognized"
    ], 404);
  }

  $versionedBranches = $branchesContainer[$versionIndex];

  return $response->withJson([
    'branches' => $versionedBranches
  ], 200);
}