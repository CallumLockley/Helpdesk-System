<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->POST('/view_all', function(Request $request, Response $response) use ($app){

        $database = $app->getContainer()->get('database');

        $tickets = $database->getAllTickets();

        $view = $app->getContainer()->get('view');
        $view->render($response,
            'view_tickets.html.twig',[
                'page_heading' => 'View All Open Tickets',
                'page_heading_1' => APP_NAME,
                'viewOption' => 'all',
                'css_path' => CSS_PATH,
                'nav_image_path' => IMAGES_PATH.'helpdesk-header-image.png',
                'dashboard_route' => URL_root . '/dashboard',
                'username' => $_SESSION['username'],
                'permission' => $_SESSION['userPerms'],
                'tickets' => $tickets
            ]);
})->setName('view_all');


$app->GET('/view_all', function(Request $request, Response $response) use ($app){

    $database = $app->getContainer()->get('database');

    $tickets = $database->getAllTickets();

    $view = $app->getContainer()->get('view');
    $view->render($response,
        'view_tickets.html.twig',[
            'page_heading' => 'View All Open Tickets',
            'page_heading_1' => APP_NAME,
            'viewOption' => 'all',
            'css_path' => CSS_PATH,
            'nav_image_path' => IMAGES_PATH.'helpdesk-header-image.png',
            'dashboard_route' => URL_root . '/dashboard',
            'username' => $_SESSION['username'],
            'permission' => $_SESSION['userPerms'],
            'tickets' => $tickets
        ]);
})->setName('view_all');