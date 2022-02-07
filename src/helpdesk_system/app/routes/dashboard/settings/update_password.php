<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/settings/update_password', function (Request $request, Response $response) use ($app) {

    $tainted = $request->getParsedBody();
    $current = $tainted['current_password'];
    $tainted_password_first = $tainted['password_first'];
    $tainted_password_second = $tainted['password_second'];
    $database = $app->getContainer()->get('database');

    checkPasswords($app, $current, $tainted_password_first, $tainted_password_second);




//    return $response->withRedirect(URL_root . '/dashboard');
});

function checkPasswords($app, $current, $first_password, $second_password)
{
    $error = false;
    var_dump(checkPasswordMatch($app, $current, $first_password, $second_password));
//    if(strlen($first_password) >= 8)
}

function checkPasswordMatch($app, $current_password, $password_one, $password_two)
{

    $error = false;
    if($password_one != $password_two)
    {
        $error = true;
    }
    if($current_password == $password_one)
    {
        $error = true;
    }
    return $error;
}

function hashPassword($app, $password)
{
    $bcrypt = $app->getContainer()->get('bcryptWrapper');
    return $bcrypt->generateHash($password);
}

function updatePassword($app, $password)
{

    $database = $app->getContainer()->get('database');

}