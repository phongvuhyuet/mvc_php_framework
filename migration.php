
<?php

use app\controllers\SiteController;

require_once __DIR__ . '\vendor\autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$config = [
	'db' => [	'dsn' => $_ENV['DB_DSN'],
	'user' => $_ENV['DB_USER'],
	'password' => $_ENV['DB_PASSWORD']
	]
];

$app = new \app\core\Application(__DIR__, $config);
$app->database->applyMigrations();