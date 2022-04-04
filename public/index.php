<?php

require_once __DIR__ . '\..\vendor\autoload.php';


$app = new \app\core\Application();
$app->router->get('/', function () {
	return 'Helloworld';
});

$app->run();