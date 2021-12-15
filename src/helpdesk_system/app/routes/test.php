<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->GET('/test',
    function(Request $request, Response $response) use ($app){


        dashboard($app, $response);

    })->setName('test');


function dashboard($app, $response) : void {
    $view = $app->getContainer()->get('view');
    $view->render($response,
        'test.html.twig',[
            'page_heading_1' => APP_NAME,
            'css_path' => CSS_PATH
        ]);

}