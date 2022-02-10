<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->POST('/view',
    function(Request $request, Response $response) use ($app){
        $database = $app->getContainer()->get('database');
        $user_id = $_SESSION['user_id'];
        $tickets = $database->getUsersTickets($user_id);
        $view = $app->getContainer()->get('view');
        $view->render($response,
            'view_tickets.html.twig',[
                'page_heading' => 'Your Tickets',
                'page_heading_1' => APP_NAME,
                'css_path' => CSS_PATH,
                'nav_image_path' => IMAGES_PATH.'helpdesk-header-image.png',
                'viewOption' => 'personal',
                'dashboard_route' => URL_root . '/dashboard',
                'username' => $_SESSION['username'],
                'permission' => $_SESSION['userPerms'],
                'tickets'=> $tickets
            ]);
    })->setName('viewTickets');

$app->GET('/view',
    function(Request $request, Response $response) use ($app){
        $database = $app->getContainer()->get('database');
        $user_id = $_SESSION['user_id'];
        $tickets = $database->getUsersTickets($user_id);
        $view = $app->getContainer()->get('view');
        $view->render($response,
            'view_tickets.html.twig',[
                'page_heading' => 'Your Tickets',
                'page_heading_1' => APP_NAME,
                'css_path' => CSS_PATH,
                'nav_image_path' => IMAGES_PATH.'helpdesk-header-image.png',
                'viewOption' => 'personal',
                'dashboard_route' => URL_root . '/dashboard',
                'username' => $_SESSION['username'],
                'permission' => $_SESSION['userPerms'],
                'tickets'=> $tickets
            ]);
    })->setName('viewTickets');