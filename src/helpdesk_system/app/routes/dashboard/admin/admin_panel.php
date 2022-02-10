<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->POST('/admin',
    function(Request $request, Response $response) use ($app){

        admin_panel($app, $response);

    })->setName('adminPanel');


function admin_panel($app, $response) : void {

    $view = $app->getContainer()->get('view');
    $view->render($response,
        'admin_panel.html.twig',[
            'page_heading_1' => APP_NAME,
            'css_path' => CSS_PATH,
            'nav_image_path' => IMAGES_PATH.'helpdesk-header-image.png',
            'username' => $_SESSION['username'],
            'permission' => $_SESSION['userPerms']
        ]);

}