<?php

use controllers\SiteController;

require_once __DIR__ . '\..\includes\autoloader.php';


$app = new core\Application(dirname(__DIR__));
$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/contact', [\controllers\SiteController::class, 'contact']);
$app->router->post('/contact', [\controllers\SiteController::class, 'handleContact']);


$app->router->get('/login', [\controllers\AuthController::class, 'login']);
$app->router->post('/login', [\controllers\AuthController::class, 'login']);
$app->router->get('/register', [\controllers\AuthController::class, 'register']);
$app->router->post('/register', [\controllers\AuthController::class, 'register']);
$app->run();