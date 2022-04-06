<?php

namespace app\core\exceptions;

use Exception;

class ForbidException extends Exception {
	protected $code = 403;
	protected $message = 'You can not access this page';
}