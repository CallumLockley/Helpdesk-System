<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/settings/update_password', function (Request $request, Response $response) use ($app) {

    $tainted = $request->getParsedBody();
    $tainted_password_first = $tainted['password_first'];
    $tainted_password_second = $tainted['password_second'];


    $validator = $app->getContainer()->get('validator');
    $checked_one = $validator->validateUpdatedPassword($tainted_password_first);
    $checked_two = $validator->validateUpdatedPassword($tainted_password_second);

    $database = $app->getContainer()->get('database');
    var_dump($database->getUserPassword(3) . "  password");

//    return $response->withRedirect(URL_root . '/dashboard');
});


function checkPasswordMatch($current_password, $password_one, $password_two)
{
    if ($password_one == $password_two) {
        if($password_one != $current_password)
        {
            return '';
        }
    }
    return $password_one;
}

function hashPassword($app, $password)
{
    if($password != '')
    {
        $bcrypt = $app->getContainer()->get('bcryptWrapper');
        return $bcrypt->generateHash($password);

    }
    return '';
}

function updatePassword($app, $password)
{

    $database = $app->getContainer()->get('database');

}