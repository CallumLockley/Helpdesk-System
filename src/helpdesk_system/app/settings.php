<?php

ini_set('display_errors', 'On');
ini_set('html_errors', 'On');

define('DIRSEP', DIRECTORY_SEPARATOR);

$url_root = $_SERVER['SCRIPT_NAME'];
$url_root = implode('/', explode('/', $url_root, -1));
$css_path = $url_root . '/css/styles.css';
$images_path = $url_root . '/images/';

define('URL_root', $url_root);
define('CSS_PATH', $css_path);
define('IMAGES_PATH', $images_path);
define('APP_NAME', 'Helpdesk System');

//Hashing - BCrypt
define('BCRYPT_AL', PASSWORD_DEFAULT);
define('BCRYPT_COST', 12);
define('BCRYPT_SALT', 'ggYQBrUdtineZNVjdnILJaATuvWNpFqY');


$ticket_priorities = ['Low','Medium', 'High'];
define('TICKET_PRIORITIES', $ticket_priorities);

$ticket_categories = ['Hardware', 'Account Details', 'Software','Other'];
define('TICKET_CATEGORIES', $ticket_categories);

$settings =
    [
        "settings" =>
            [
                'displayErrorDetails' => true,
                'addContentLengthHeader' => false,
                'mode' => 'development',
                'debug' => true,
                'class_path' => __DIR__ . '/src/',
                'view' =>
                    [
                        'template_path' => __DIR__ . '/templates/',
                        'twig' =>
                            [
                                'cache' => false,
                                'auto_reload' => true,
                            ]],
            ],
        "database_settings" =>
            [
                'host' => 'localhost',
                'user' => 'root',
                'password' => '',
                'database_name' => 'helpdesk_system'

            ]
    ];

return $settings;
