<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/auth', function (Request $request, Response $response) use ($app) {

    $tainted = $request->getParsedBody();


    $user = "root";
    $pass = "";
    $host = "localhost";
    $dbdb = "helpdesk_system";

    $conn = new mysqli($host, $user, $pass, $dbdb);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        return $redirect = $response->withRedirect(URL_root . '/');
    }else{
        return $redirect = $response->withRedirect(URL_root . '/', 301);

    }
});

function authUser($app, $response) : void
{
    $view = $app->getContainer()->get('view');
    $view->render(
        $response,
        'dashboard_page.html.twig',
        [
            'page_heading_1' => APP_NAME,
            'css_path' => CSS_PATH,
        ]
    );
}