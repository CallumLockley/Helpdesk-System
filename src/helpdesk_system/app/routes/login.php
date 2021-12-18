<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response) use ($app) {

    $options= array(
        'cost'=>BCRYPT_COST,
    );

    $test = password_hash('test', BCRYPT_AL, $options);

    homePage($app, $response, $test);

})->setName('logIn');

function homePage($app, $response, $test) : void
{
    $view = $app->getContainer()->get('view');
    $view->render(
        $response,
        'login_page.html.twig',
        [
            'page_heading_1' => APP_NAME,
            'css_path' => CSS_PATH,
            'match' => $_SESSION['result'],
        ]
    );
}
