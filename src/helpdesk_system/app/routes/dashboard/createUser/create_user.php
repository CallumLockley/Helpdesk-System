<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->POST('/user',
    function(Request $request, Response $response) use ($app){
        $view = $app->getContainer()->get('view');
        $view->render($response,
            'create_user.html.twig',[
                'error' => 0,
                'username' => $_SESSION['username'],
                'permission' => $_SESSION['userPerms'],
                'page_heading_1' => APP_NAME,
                'css_path' => CSS_PATH,
                'nav_image_path' => IMAGES_PATH.'helpdesk-header-image.png',
                'create_user_route' => URL_root . '/process_user'
            ]);
    })->setName('user');

$app->GET('/user',
    function(Request $request, Response $response) use ($app){
        if($_SESSION['username'] == NULL)
        {
            return $response->withRedirect(URL_root . '/');
        }else{
        $view = $app->getContainer()->get('view');
        $view->render($response,
            'create_user.html.twig',[
                'error' => $_SESSION['newUserError'],
                'username' => $_SESSION['username'],
                'permission' => $_SESSION['userPerms'],
                'page_heading_1' => APP_NAME,
                'css_path' => CSS_PATH,
                'nav_image_path' => IMAGES_PATH.'helpdesk-header-image.png',
                'create_user_route' => URL_root . '/process_user'
            ]);}
    })->setName('user');