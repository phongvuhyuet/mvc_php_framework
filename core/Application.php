<?php
namespace app\core;

use Exception;

class Application {
	public static string $ROOT_DIR;
	public static Application $app; 


	public Router $router;
	public Request $request;
	public Response $response;
	public ?Controller $controller = null;
	public Database $database;
	public Session $session;
	public ?DbModel $user = null;
	public string $userClass;
	public string $layout = 'main' ;


	public function __construct($rootPath, array $config) {

		$this->session = new Session();
		$this->request = new Request();
		$this->response = new Response();
		$this->router = new Router($this->request, $this->response);
		$this->database = new Database($config);
		self::$ROOT_DIR = $rootPath;
		self::$app = $this;
		$this->userClass = $config['userClass'];
		$primaryVal = $this->session->get('user');
		if ($primaryVal) {
			$primaryKey = $this->userClass::primaryKey();
			$this->user = $this->userClass::findOne([$primaryKey=> $primaryVal]);
		} else {
			$this->user = null;
		}
	}

	public function run() {
		try {
					echo $this->router->resolve();

		} catch(Exception $error) {
			echo $this->router->renderView('_error', [
				'exception' => $error
			]);
		}
	}

	public function login(DbModel $user) {

		$this->user = $user;
		$primaryKey = $user->primaryKey();
		$primaryVal = $user->{$primaryKey};
		$this->session->set('user', $primaryVal);
		return $user;
	}

	public function logout() {
		$this->user = null;
		$this->session->remove('user');
	}

	public function isGuest() {
		return $this->user === null;
	}
}