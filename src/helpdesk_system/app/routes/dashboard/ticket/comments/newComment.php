<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->POST('/view_ticket/{id}/new_comment', function (Request $request, Response $response) use ($app) {

    $tainted = $request->getParsedBody();
    $comment = $tainted['message'];
    $ticketId = $request->getAttribute('id');
    $userId =  $_SESSION['userId'];
    $database = $app->getContainer()->get('database');
    $database->newComment($ticketId, $userId, $comment);
    $database->logActivity($userId, 'New comment attached to ticket.');
    return $response->withRedirect(URL_root . '/view_ticket/'.$ticketId);
});
