<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->POST('/view',
    function(Request $request, Response $response) use ($app){

        view_tickets($app, $response);

    })->setName('viewTickets');


function view_tickets($app, $response) : void {

    $view = $app->getContainer()->get('view');
    $view->render($response,
        'view_tickets.html.twig',[
            'page_heading_1' => APP_NAME,
            'css_path' => CSS_PATH,
            'username' => $_SESSION['username'],
            'permission' => $_SESSION['userPerms']
        ]);

}