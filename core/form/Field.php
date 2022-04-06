<?php
namespace app\core\form;

use app\core\Model;

class Field {
	public const TYPE_TEXT = 'text';
	public const TYPE_PASSWORD = 'password';
	public const TYPE_EMAIL = 'email';

	public Model $model;
	public $attribute;
	public $type ;
	public function __construct(Model $model, $attribute) {
		$this->model = $model;
		$this->attribute = $attribute;
		$this->type = self::TYPE_TEXT;
	}
	public function __toString()
	{
		return sprintf('<div class="mb-3 form-group">
    <label class="form-label" >%s</label>
	<input type="%s" value="%s" class="form-control %s" name="%s">
	<div class="invalid-feedback">%s</div>
  </div>', $this->model->labels()[$this->attribute], $this->type, $this->model->{$this->attribute},
		$this->model->hasError($this->attribute) ? 'is-invalid': '', $this->attribute,
		$this->model->hasError($this->attribute) ? $this->model->getFirstError($this->attribute) : ''
);
	
}
	public function passwordField() {
		$this->type = self::TYPE_PASSWORD;
		return $this;
	}
}