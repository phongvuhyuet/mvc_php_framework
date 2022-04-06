<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class SiteController extends Controller
{
	public function home(Request $request) {
		return $this->render('home');
	}
	public function contact(Request $request) {
		return $this->render('contact', [
			'phong' => 'phongdsfa'
		]);
	}
    public function handleContact(Request $request)
    {
		$body = $request->getBody();
		return "handling submitted data";
    }
}
