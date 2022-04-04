<?php
namespace core;

class Application {
	public static string $ROOT_DIR;
	public static Application $app; 


	public Router $router;
	public Request $request;
	public Response $response;
	public function __construct($rootPath) {

		$this->request = new Request();
		$this->response = new Response();
		$this->router = new Router($this->request, $this->response);
		self::$ROOT_DIR = $rootPath;
		self::$app = $this;
	}

	public function run() {
		echo $this->router->resolve();
	}
}