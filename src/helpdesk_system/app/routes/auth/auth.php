<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/auth', function (Request $request, Response $response) use ($app) {

    $tainted = $request->getParsedBody();
    $tainted_username = $tainted['username'];
    $tainted_password = $tainted['password'];

    $validator = $app->getContainer()->get('validator');
    $_SESSION['username'] = $validator->validateEmail($tainted_username);

    $database = $app->getContainer()->get('database');
    $password = $database->checkLoginDetails($_SESSION['username'], $tainted_password);

    if($password){
        return  $response->withRedirect(URL_root . '/dashboard');
    }else{
        $_SESSION['loginError'] = true;
        $result = $response->withRedirect(URL_root . '/');
        return $result;
    }
});
