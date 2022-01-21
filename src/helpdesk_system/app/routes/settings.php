<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->POST('/settings',
    function(Request $request, Response $response) use ($app){

        settings($app, $response);

    })->setName('settings');


function settings($app, $response) : void {

    $view = $app->getContainer()->get('view');
    $view->render($response,
        'settings.html.twig',[
            'page_heading_1' => APP_NAME,
            'css_path' => CSS_PATH,
            'dashboard_route' => URL_root . '/dashboard',
            'username' => $_SESSION['username'],
            'permission' => $_SESSION['userPerms'],
        ]);
}