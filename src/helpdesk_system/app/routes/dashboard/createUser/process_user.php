<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->POST('/process_user',
    function(Request $request, Response $response) use ($app){
        $database = $app->getContainer()->get('database');

        $tainted = $request->getParsedBody();
        $username = $tainted['username'];
        $password_first = $tainted['password_first'];
        $password_second = $tainted['password_second'];
        $permission = $tainted['permission'];

        if($password_first === $password_second){
            $userPassword = verify($app,$password_first);
            if($userPassword != "") {
                if ($database->insertUser($username, $userPassword, $permission)){
                    $database->logActivity($_SESSION['userId'], 'New user created: ' . $username);
                    return $response->withRedirect(URL_root . '/dashboard');
                }
            }else {
                $_SESSION['newUserError'] = 1;
                return $response->withRedirect(URL_root . '/user');
            }
        }else{
            $_SESSION['newUserError'] = 1;
            return $response->withRedirect(URL_root . '/user');
        }

    });
//
function verify($app, $password) {
    if(checkNewPassword($password))
    {
        return $app->getContainer()->get('bcryptWrapper')->generateHash($password);
    }
    return "";

}
//
function newUserPassword($password): bool
{
    // Validate password strength
    $upper = preg_match('@[A-Z]@', $password);
    $lower = preg_match('@[a-z]@', $password);
    $num    = preg_match('@[0-9]@', $password);
    $special = preg_match('@[^\w]@', $password);

    if(!$upper || !$lower || !$num || !$special || strlen($password) <= 8) {
        return false;
    }else{
        return true;
    }
}
