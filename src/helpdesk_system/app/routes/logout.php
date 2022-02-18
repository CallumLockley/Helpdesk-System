<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/logout',
    function(Request $request, Response $response) use ($app){
        session_destroy();
        $database = $app->getContainer()->get('database');
        $user_id = $_SESSION['userId'];
        $database->logActivity($user_id, 'User logged out.');
        return $redirect = $response->withRedirect(URL_root . '/');
})->setName("logout");