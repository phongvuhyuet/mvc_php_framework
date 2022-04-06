<?php

namespace app\core;

class Session {
	public const FLASH_KEY = 'flash_messages';
	
	public function __construct()
	{
		session_start();

		$flashMessages = $_SESSION[self::FLASH_KEY] ??[];

		foreach ($flashMessages as $key => $value) {
			$flashMessages[$key]['to_remove'] = true;		
		}
		$_SESSION[self::FLASH_KEY] = $flashMessages;
	}

	public function setFlash($key, $message) {
		$_SESSION[self::FLASH_KEY][$key] = [
			'to_remove' => false,
			'value' => $message
		];
	}

	public function getFlash($key) {
		return $_SESSION[self::FLASH_KEY][$key];
	}

	public function get($key) {
		return $_SESSION[$key] ?? false;
	}

	public function set($key, $value) {
		return $_SESSION[$key] = $value;
	}

	public function remove($key) {
		unset($_SESSION[$key]);
	}

	public function __destruct()
	{
		$flashMessages = $_SESSION[self::FLASH_KEY];

		foreach ($flashMessages as $key => $value) {
			if ($value['to_remove'] === true) {

				unset($flashMessages[$key]);
			}
		}
		$_SESSION[self::FLASH_KEY] = $flashMessages;
	}
}