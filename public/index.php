<?php

require_once __DIR__ . '\..\includes\autoloader.php';


$app = new core\Application(dirname(__DIR__));
$app->router->get('/', 'home');

$app->router->get('/contact', 'contact');
$app->router->post('/contact', function () {
	return 'handling data';
});

$app->run();