<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->POST('/admin',
    function(Request $request, Response $response) use ($app){

        $database = $app->getContainer()->get('database');
        $totalTickets = getTickets($database);
        $openTickets = getOpenTickets($database);
        $priority = $database->getPriorityTicketCount();
        $categorys = $database->getCommonCategory();
        $value = max($categorys);

        if($value != 0){
            $highestCategory = ucfirst(array_search($value, $categorys));
        }else{
            $highestCategory = 'No Open Tickets';
        }

        $ticket_times = $database->getAverageDuration();
        $averageDuration = average($ticket_times);

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
                'average_duration' => $averageDuration,
                'common_category' => $highestCategory,
            ]);

})->setName('adminPanel');

function average($tickets)
{
    $amount = 0;
    $average = 0;
    $hours = 0;
    foreach($tickets as $ticket) {
        $amount += strtotime($ticket['closed']) - strtotime($ticket['created']);
    }
    if(count($tickets) == 0)
    {
        $average = 'No Open Tickets';
    }else{
        $amount / count($tickets);
        $hours = round($average/3600,2);
        if($hours < 1){
            return ($hours*60) . 'minutes';
        }
        if($hours > 1)
        {
            $explodedTime = explode('.', $hours);
            $minutes = ($explodedTime[1]*60) / 100;
            return $explodedTime[0]. ' hours ' . $minutes . ' minutes';
        }
        return $hours . 'hours';
    }
    return $average;
}
function getTickets($database){
    return $database->getAmountTickets();
}
function getOpenTickets($database){
    return $database->getAmountTicketsOpen();
}
