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
    $bcrypt = $app->getContainer()->get('bcryptWrapper');
    $passwordData = $database->checkLoginDetails($validated_username);


    var_dump($bcrypt->generateHash('test'));
    var_dump($passwordData['password']);
    if(password_verify($tainted_password.BCRYPT_SALT, $passwordData['password']))
    {
        session_reset();
        $_SESSION['userId'] = $passwordData['userId'];
        $_SESSION['username'] = $validated_username;
        $_SESSION['userPerms'] = $passwordData['permission'];
        $user_id = $_SESSION['userId'];
        $database->logActivity($user_id, 'User logged in.');
        return  $response->withRedirect(URL_root . '/dashboard');

    }else{
        $_SESSION['loginError'] = true;
        return $response->withRedirect(URL_root . '/');
    }
});
