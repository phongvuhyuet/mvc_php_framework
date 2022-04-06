<?php
namespace app\core;


class Application {
	public static string $ROOT_DIR;
	public static Application $app; 


	public Router $router;
	public Request $request;
	public Response $response;
	public Controller $controller;
	public Database $database;
	public Session $session;
	public function __construct($rootPath, array $config) {

		$this->session = new Session();
		$this->request = new Request();
		$this->response = new Response();
		$this->router = new Router($this->request, $this->response);
		$this->database = new Database($config);
		self::$ROOT_DIR = $rootPath;
		self::$app = $this;
	}

	public function run() {
		echo $this->router->resolve();
	}
}