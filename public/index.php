<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require '../config/dev.php';
require '../vendor/autoload.php';
session_start();
$loader = new FilesystemLoader('../templates/twig');
$twig = new Environment($loader, [
    'debug' => true,
]);
$twig->addGlobal('session', $_SESSION);

$router = new \App\config\Router($twig);
$router->run();
