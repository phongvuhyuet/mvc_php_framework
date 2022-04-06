<?php

namespace app\core\middlewares;

use app\core\Application;
use app\core\exceptions\ForbidException;

class AuthMiddleware extends BaseMiddleware{
	protected $actions = [];
	public function __construct($actions = []) {
		$this->actions = $actions;
	}

	 public function execute() {
		 if (Application::$app->isGuest()) {
			if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
				throw new ForbidException();
			}
		 }
	 }
}