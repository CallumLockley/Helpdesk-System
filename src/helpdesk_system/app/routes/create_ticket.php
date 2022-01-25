<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->POST('/create',
    function(Request $request, Response $response) use ($app){

        create_ticket($app, $response);

    })->setName('createTicket');


function create_ticket($app, $response) : void {

    $view = $app->getContainer()->get('view');
    $view->render($response,
        'create_ticket.html.twig',[
            'page_heading_1' => APP_NAME,
            'css_path' => CSS_PATH,
            'dashboard_route' => URL_root . '/dashboard',
            'username' => $_SESSION['username'],
            'permission' => $_SESSION['userPerms'],
            'ticket_priorities' => TICKET_PRIORITIES,
            'ticket_categories' => TICKET_CATEGORIES
        ]);
}