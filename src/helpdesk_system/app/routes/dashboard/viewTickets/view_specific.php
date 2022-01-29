<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
$app->POST('/view_ticket/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');



    $response->getBody()->write("Hello, $id");
    return $response;
});
