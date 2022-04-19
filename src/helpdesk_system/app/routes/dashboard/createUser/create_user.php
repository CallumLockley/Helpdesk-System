<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->POST('/user',
    function(Request $request, Response $response) use ($app){
        $view = $app->getContainer()->get('view');
        $view->render($response,
            'create_user.html.twig',[
                'page_heading_1' => APP_NAME,
                'css_path' => CSS_PATH,
                'nav_image_path' => IMAGES_PATH.'helpdesk-header-image.png',
            ]);
    })->setName('user');
