<?php
namespace core;
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
			return $this->renderView('_404');
		}
		if (is_string($callback)) {
			return $this->renderView($callback);
		}
		return call_user_func($callback);
	}

	private function renderView($view) {
		$layoutContent = $this->renderLayout();
		$viewContent = $this->renderViewOnly($view);
		return str_replace('{{content}}', $viewContent, $layoutContent);
	}

	private function renderViewOnly($view) {
		ob_start();
		include_once  Application::$ROOT_DIR."/views/{$view}.php";
		return ob_get_clean();
	}
	private function renderLayout() {
		ob_start();
		include_once  Application::$ROOT_DIR. "/views/layouts/main.php";
		return ob_get_clean();
	}

}





