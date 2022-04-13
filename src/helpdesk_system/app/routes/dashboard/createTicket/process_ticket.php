<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/process_ticket', function (Request $request, Response $response) use ($app) {

    $tainted = $request->getParsedBody();

    $ticket_content['title'] = $tainted['title'];
    $ticket_content['description'] = $tainted['description'];
    $ticket_content['priority'] = $tainted['priority'];
    $ticket_content['category'] = $tainted['category'];

    $user_id = $_SESSION['userId'];
    $database = $app->getContainer()->get('database');
    $inserted  = $database->createTicket($user_id, $ticket_content);

    if($inserted)
    {
        $database->logActivity($_SESSION['userId'], 'New ticket created.');
        return  $response->withRedirect(URL_root . '/dashboard');
    }
});
