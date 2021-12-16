<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/logout',
    function(Request $request, Response $response) use ($app){
        session_destroy();
        return $redirect = $response->withRedirect(URL_root . '/');
})->setName("logout");