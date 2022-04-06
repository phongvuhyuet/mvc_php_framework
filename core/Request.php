<?php

namespace app\core;

class Request {
	public function getPath() {
		$uri = $_SERVER['REQUEST_URI'] ?? '/';
		$position = strpos($uri, '?');
		if ($position === false) {
			return $uri;
		}
		return substr($uri, 0, $position);
	}
	public function getMethod() {
		return $_SERVER['REQUEST_METHOD'];
	}

	public function isGet() {
		return $this->getMethod() === 'GET';
	}

	public function isPost() {
		return $this->getMethod() === 'POST';
	}
	public function getBody() {
		$body = [];

		if ($this->isGet()) {
			foreach ($_GET as $key => $value) {
				$body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
			return $body;
		}
		if ($this->isPost()) {
			foreach ($_POST as $key => $value) {
				$body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}
		return $body;
	}
}