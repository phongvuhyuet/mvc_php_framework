<?php

namespace controllers;
use core\Controller;
use core\Request;
use models\RegisterModel;

class AuthController extends Controller {

	public function login(Request $request) {
		if ($request->isGet()) {
			$this->setLayout('guest');
			return $this->render('login');
		}
		return 'handling submitted data';
		
	}
	public function register(Request $request) {
		$registerModel = new RegisterModel();
		if ($request->isGet()) {
			$this->setLayout('guest');
			return $this->render('register');
		}
		$registerModel->loadData($request->getBody());
		if ($registerModel->validate() && $registerModel->register()) {
			echo '<pre>';
			var_dump($registerModel);
			echo'</pre>';
			exit;
			return 'success';
		}
		return 'handling submitted data';
		
	}
}