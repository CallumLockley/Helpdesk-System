<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->POST('/admin',
    function(Request $request, Response $response) use ($app){

        $database = $app->getContainer()->get('database');
        $totalTickets = getTickets($database);
        $openTickets = getOpenTickets($database);
        $priority = $database->getPriorityTicketCount();
        $category = $database->getCommonCategory();
        $value = max($category);
        $highestCategory = ucfirst(array_search($value, $category));

        $ticket_times = $database->getAverageDuration();

        average($ticket_times);


        $view = $app->getContainer()->get('view');
        $view->render($response,
            'admin_panel.html.twig',[
                'page_heading_1' => APP_NAME,
                'css_path' => CSS_PATH,
                'nav_image_path' => IMAGES_PATH.'helpdesk-header-image.png',
                'username' => $_SESSION['username'],
                'pri_low' => $priority['low'],
                'pri_medium' => $priority['medium'],
                'pri_high' => $priority['high'],
                'total_tickets' => $totalTickets,
                'open_tickets' => $openTickets,
                'average_duration' => 4,
                'common_category' => $highestCategory,
            ]);

})->setName('adminPanel');

function average($tickets)
{
    foreach($tickets as $ticket) {
        $created_date = substr($ticket['created'], 0,10);
        $created_time = trim(substr($ticket['created'], 10));
        $closed_date = substr($ticket['closed'], 0,10);
        $closed_time = trim(substr($ticket['closed'], 10));

        $date1 = date_create_from_format('Y-m-d', $created_date);
        $date2 = date_create_from_format('Y-m-d', $closed_date);

        $diff = date_diff($date1, $date2);
        var_dump($diff);
    }

}
function getTickets($database){
    return $database->getAmountTickets();
}
function getOpenTickets($database){
    return $database->getAmountTicketsOpen();
}
