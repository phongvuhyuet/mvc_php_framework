<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\User;

class AuthController extends Controller {

	public function login(Request $request) {
		if ($request->isGet()) {
			$this->setLayout('guest');
			return $this->render('login');
		}
		return 'handling submitted data';
		
	}
	public function register(Request $request) {
		$user = new User();
		if ($request->isGet()) {
			$this->setLayout('guest');
			return $this->render('register', [
				'model' => $user
			]);
		}
		$user->loadData($request->getBody());
		if ($user->validate() && $user->save()) {
			Application::$app->session->setFlash('success', 'Thank for register!');
			Application::$app->response->redirect("/");
		}
		return $this->render('register', [
			'model' => $user
		]);
		
	}
}