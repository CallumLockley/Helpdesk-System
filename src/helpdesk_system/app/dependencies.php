
<?php

// Register component on container
$container['view'] = function ($container)
{
    $view = new \Slim\Views\Twig(
        $container['settings']['view']['template_path'],
        $container['settings']['view']['twig'],
        [
            'debug' => true // This line should enable debug mode
        ]
    );

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new \Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

$container['validator'] = function($container){
    $validator = new \HelpdeskSystem\Validator();
    return $validator;
};

$container['database'] = function($container) {
    $database = new \HelpdeskSystem\DatabaseWra();
    return $database;
};
