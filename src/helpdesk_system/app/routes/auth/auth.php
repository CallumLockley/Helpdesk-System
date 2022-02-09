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
    $bcrypt = $app->getContainer()->get('bcryptWrapper');
    $passwordData = $database->checkLoginDetails($_SESSION['username']);


    var_dump($bcrypt->generateHash('test'));
    var_dump($passwordData['password']);
    if(password_verify($tainted_password.BCRYPT_SALT, $passwordData['password']))
    {
        session_reset();
        $_SESSION['user_id'] = $passwordData['userId'];
        $_SESSION['username'] = $_SESSION['username'];
        $_SESSION['userPerms'] = $passwordData['permission'];
        $password_result = true;
        return  $response->withRedirect(URL_root . '/dashboard');

    }else{
        $_SESSION['loginError'] = true;
        return $response->withRedirect(URL_root . '/');
    }
//
//
//
//        if (password_verify($password, $row['password']))
//        {

//        }else{
//        }
//    }
//    return $password_result;
//
//    if($password){
//    }else{
//        $_SESSION['loginError'] = true;
//        $result = $response->withRedirect(URL_root . '/');
//        return $result;
//    }
});
