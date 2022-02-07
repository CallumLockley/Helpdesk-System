<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->POST('/view_ticket/{id}/new_comment', function (Request $request, Response $response) use ($app) {

    $tainted = $request->getParsedBody();
    $id = $request->getAttribute('id');

    return $response->withRedirect(URL_root . '/view_ticket/'.$id);
});
