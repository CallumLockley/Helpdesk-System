<?php
session_start();

require '../vendor/autoload.php';

$settings = require __DIR__ . '/app/settings.php';

//if (function_exists('xdebug_start_trace'))
//{
//  xdebug_start_trace();
//}

$container = new \Slim\Container($settings);

require __DIR__ . '/app/dependencies.php';

$app = new \Slim\App($container);

require __DIR__ . '/app/routes.php';

$app->run();