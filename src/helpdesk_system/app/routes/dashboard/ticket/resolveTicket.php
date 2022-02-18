<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->POST('/view_ticket/{id}/resolve', function (Request $request, Response $response) use ($app) {
    $ticketId = $request->getAttribute('id');
    $database = $app->getContainer()->get('database');
    $database->resolveTicket($ticketId);
    $userId = $_SESSION['userId'];
    $database->logActivity($userId, 'Ticket resolved.');
    return $response->withRedirect(URL_root . '/dashboard');
});
