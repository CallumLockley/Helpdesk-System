<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->POST('/view_ticket/{id}',     function(Request $request, Response $response) use ($app){

    $id = $request->getAttribute('id');
    if($id == 'logout')
    {
        return  $response->withRedirect(URL_root . '/');
    }else{
        $database = $app->getContainer()->get('database');
        $ticket = $database->getSpecificTicket($id);
        $comments = $database->getTicketsComment($ticket[0]['id']);
        if(!empty($comments))
        {
            var_dump($comments);

            var_dump('true');
        }else
        {
            var_dump('falsse');
        }

        $view = $app->getContainer()->get('view');
        $view->render($response,
            'view_specific_ticket.html.twig',[
                'page_heading' => 'Ticket ' . $id . ' - ' . $ticket[0]['title'],
                'page_heading_1' => APP_NAME,
                'viewOption' => 'all',
                'css_path' => CSS_PATH,
                'dashboard_route' => URL_root . '/dashboard',
                'username' => $_SESSION['username'],
                'permission' => $_SESSION['userPerms'],
                'ticket' => $ticket[0],
                'comments' => $comments
            ]);
    }

});
