<?php
namespace app\core;

use app\core\middlewares\BaseMiddleware;

class Controller
{
	public $layout = 'main';
	public $action = '';
	protected array $middlewares = [];
    public function render($view, $params = [])
    {
        return Application::$app->router->renderView($view, $params);
    }

	public function setLayout($layout) {

		$this->layout = $layout;
	
	}
	public function registerMiddleware(BaseMiddleware $middleware) {
		$this->middlewares[] = $middleware;
	}

	public function getMiddlewares() {
		return $this->middlewares;
	}
}
