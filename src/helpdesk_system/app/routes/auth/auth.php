<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/auth', function (Request $request, Response $response) use ($app) {

    $tainted = $request->getParsedBody();
    $tainted_username = $tainted['username'];
    $tainted_password = $tainted['password'];

    $validator = $app->getContainer()->get('validator');
    $validated_username = $validator->validateEmail($tainted_username);

    $database = $app->getContainer()->get('database');
    $passwordData = $database->checkLoginDetails($validated_username);

    if(password_verify($tainted_password.BCRYPT_SALT, $passwordData['password']))
    {
        session_reset();
        $_SESSION['userId'] = $passwordData['userId'];
        $_SESSION['username'] = $validated_username;
        $_SESSION['userPerms'] = $passwordData['permission'];
        $database->logActivity($_SESSION['userId'], 'User logged in.');
        return  $response->withRedirect(URL_root . '/dashboard');
    }else{
        $_SESSION['loginError'] = true;
        return $response->withRedirect(URL_root . '/');
    }
});
