<?php
namespace app\core;

use app\core\exceptions\NotFoundException;

class Router {
	protected array $routes = [];
	public Request $request;
	public Response $response;

	public function __construct(Request $request, Response $response) {
		$this->request = $request;
		$this->response = $response;
	}

	public function get($path, $callback) {
		$this->routes['GET'][$path] = $callback;
	}

	public function post($path, $callback) {
		$this->routes['POST'][$path] = $callback;
	}

	public function resolve() {
		$path = $this->request->getPath();
		$method = $this->request->getMethod();
		$callback = $this->routes[$method][$path] ?? false;
		if ($callback === false) {
			$this->response->setStatusCode(404);
			throw new NotFoundException();
		}
		if (is_string($callback)) {
			return $this->renderView($callback);
		} 
		$controller =  new $callback[0];
		$callback[0] = $controller;
		Application::$app->controller = $callback[0];
		$controller->action = $callback[1]; 
		foreach ($controller->getMiddlewares() as $middleware) {
			$middleware->execute();
		}

		return call_user_func($callback, $this->request, $this->response);
	}

	public function renderView($view, $params = []) {
		$layoutContent = $this->renderLayout();
		$viewContent = $this->renderViewOnly($view, $params);
		return str_replace('{{content}}', $viewContent, $layoutContent);
	}

	private function renderViewOnly($view, $params) {

		ob_start();
		foreach ($params as $key => $value) {
			$$key = $value;
		}

		include_once  Application::$ROOT_DIR."/views/{$view}.php";
		return ob_get_clean();
	}
	private function renderLayout() {
		$layout = Application::$app->layout;
		if (Application::$app->controller) {
			$layout = Application::$app->controller->layout;

		}
		ob_start();
		include_once  Application::$ROOT_DIR. "/views/layouts/$layout.php";
		return ob_get_clean();
	}

}





