<?php
namespace app\core;
class Router {
	protected array $routes = [];
	public Request $request;

	public function __construct(Request $request) {
		$this->request = $request;
	}

	public function get($path, $callback) {
		$this->routes['GET'][$path] = $callback;
	}
	public function resolve() {
		$path = $this->request->getPath();
		$method = $this->request->getMethod();
		$callback = $this->routes[$method][$path] ?? false;
		if ($callback === false) {
			return '404 not found';
		}

		return call_user_func($callback);
	}

}





