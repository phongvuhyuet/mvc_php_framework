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
}