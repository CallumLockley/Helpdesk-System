<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->GET('/dashboard',
    function(Request $request, Response $response) use ($app){
    $this->database->openConnection();

    if($_SESSION['username'] == NULL)
    {
        return $response->withRedirect(URL_root . '/');
    }else{
        $view = $app->getContainer()->get('view');
        $view->render($response,
            'dashboard_page.html.twig',[
                'page_heading_1' => APP_NAME,
                'css_path' => CSS_PATH,
                'username' => $_SESSION['username'],
                'permission' => $_SESSION['userPerms'],
                'dashboard_route' => URL_root . '/dashboard',
                'nav_image_path' => IMAGES_PATH.'helpdesk-header-image.png'
            ]);    }
})->setName('dashboard');
