<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\User;

class AuthController extends Controller {
	public function __construct()
	{
		$this->registerMiddleware(new AuthMiddleware(['profile']));
	}

	public function login(Request $request, Response $response) {
		$loginForm = new LoginForm();
		if ($request->isGet()) {
			$this->setLayout('guest');
			return $this->render('login', [
				'model' => $loginForm
			]);
		}
		$loginForm->loadData($request->getBody());
		if ($loginForm->validate() && $loginForm->login()) {
			$this->setLayout('main');
			$response->redirect('/');
			return;
		}
		$this->setLayout('guest');
		return $this->render('login', [
			'model' => $loginForm
		]);
		
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
	public function logout(Request $request, Response $response) {
		Application::$app->logout();
		$response->redirect('/');
	}

	public function profile(Request $request, Response $response) {
		return $this->render('profile');
	}
}