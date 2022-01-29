<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->POST('/view_ticket/{id}',     function(Request $request, Response $response) use ($app){

    $id = $request->getAttribute('id');

    $view = $app->getContainer()->get('view');
    $view->render($response,
        'view_specific_ticket.html.twig',[
            'page_heading' => 'View All Open Tickets',
            'page_heading_1' => APP_NAME,
            'viewOption' => 'all',
            'css_path' => CSS_PATH,
            'dashboard_route' => URL_root . '/dashboard',
            'username' => $_SESSION['username'],
            'permission' => $_SESSION['userPerms'],
            'tickets' => $id
        ]);
});
