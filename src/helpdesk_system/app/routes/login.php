<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response) use ($app) {


    homePage($app, $response);

})->setName('logIn');

function homePage($app, $response) : void
{
    $view = $app->getContainer()->get('view');
    $view->render(
        $response,
        'login_page.html.twig',
        [
            'page_heading_1' => APP_NAME,
            'css_path' => CSS_PATH,
        ]
    );
}
