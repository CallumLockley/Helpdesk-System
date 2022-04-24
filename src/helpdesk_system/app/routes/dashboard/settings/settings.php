<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->POST('/update_password',
    function(Request $request, Response $response) use ($app){

        $view = $app->getContainer()->get('view');
        $view->render($response,
            'settings_update_password.html.twig',[
                'page_heading_1' => APP_NAME,
                'css_path' => CSS_PATH,
                'nav_image_path' => IMAGES_PATH.'helpdesk-header-image.png',
                'dashboard_route' => URL_root . '/dashboard',
                'username' => $_SESSION['username'],
                'permission' => $_SESSION['userPerms'],
                'error' => 0
            ]);
    })->setName('settings');

$app->GET('/update_password',
    function(Request $request, Response $response) use ($app){
        if($_SESSION['username'] == NULL)
        {
            return $response->withRedirect(URL_root . '/');
        }else{
        $view = $app->getContainer()->get('view');
        $view->render($response,
            'settings_update_password.html.twig',[
                'page_heading_1' => APP_NAME,
                'css_path' => CSS_PATH,
                'nav_image_path' => IMAGES_PATH.'helpdesk-header-image.png',
                'dashboard_route' => URL_root . '/dashboard',
                'username' => $_SESSION['username'],
                'permission' => $_SESSION['userPerms'],
                'error' => $_SESSION['updateError']
            ]);}
    })->setName('update_password');