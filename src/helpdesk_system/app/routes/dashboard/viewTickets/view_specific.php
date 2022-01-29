<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
$app->POST('/view_ticket/{id}', function (Request $request, Response $response) {
    $name = $request->getAttribute('id');
    $response->getBody()->write("Hello, $name");
    return $response;
});
