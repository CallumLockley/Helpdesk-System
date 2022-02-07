<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->POST('/view_ticket/{id}/new_comment', function (Request $request, Response $response) use ($app) {

    $tainted = $request->getParsedBody();
    $comment = $tainted['message'];
    $ticketId = $request->getAttribute('id');
    $userId = $_SESSION['user_id'];
    $database = $app->getContainer()->get('database');
    var_dump($userId);
    var_dump($ticketId);
    var_dump($comment);
    $database->newComment($ticketId, $userId, $comment);
    return $response->withRedirect(URL_root . '/dashboard');
});
