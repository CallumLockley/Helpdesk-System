<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/auth', function (Request $request, Response $response) use ($app) {

    $tainted = $request->getParsedBody();
    $tainted_username = $tainted['username'];

    $validator = $app->getContainer()->get('validator');
    $_SESSION['username'] = $validator->validateEmail($tainted_username);


    $database = $app->getContainer()->get('database');
    $count = $database->checkLoginDetails($_SESSION['username'], $tainted['password']);


    if($count == 1){
        return $redirect = $response->withRedirect(URL_root . '/dashboard');

    }else{
        return $redirect = $response->withRedirect(URL_root . '/');
    }
});