<?php

namespace app\core;

abstract class Model{
	public const RULE_REQUIRED = 'required';
	public const RULE_EMAIL = 'email';
	public const RULE_MIN = 'min';
	public const RULE_MAX = 'max';
	public const RULE_MATCH = 'match';
	public const RULE_UNIQUE = 'unique';

	public array $errors = [];

	public function loadData($data) {

		foreach ($data as $key => $value) {
			if (property_exists($this, $key)) {
				$this->{$key} = $value;
			}
		}
	} 
	public function validate() {
		foreach ($this->rules() as $attribute => $rules) {
			$value = $this->{$attribute};
			foreach ($rules as $rule) {
				$ruleName = $rule;
				if (!is_string($ruleName)) {
					$ruleName = $rule[0];
				}
				if ($ruleName === self::RULE_REQUIRED && !$value) {
					$this->addErrorForValidation($attribute, self::RULE_REQUIRED);
				}
				if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
					$this->addErrorForValidation($attribute, self::RULE_MIN, $rule);
				}
				if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
					$this->addErrorForValidation($attribute, self::RULE_MAX, $rule);
				}
				if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
					$rule['match'] = $this->getLabel($rule['match']);
					$this->addErrorForValidation($attribute, self::RULE_MATCH, $rule);
				}
				if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
					$this->addErrorForValidation($attribute, self::RULE_EMAIL);
				}
				if ($ruleName === self::RULE_UNIQUE) {
					$tableName = $rule['class'];
					$tableName = $tableName::tableName();
					$uniqueField = $rule['field'];
					$statement = Application::$app->database->prepare("select * from $tableName where $uniqueField = :$uniqueField");
					$statement->bindValue(":$uniqueField", $value);
					$statement->execute();
					$result = $statement->fetchObject();

					if ($result) {
						$this->addErrorForValidation($attribute, self::RULE_UNIQUE, ['field' => $this->getLabel($rule['field'])]);
					}

				}
			}
		}
		return empty($this->errors);
	}

	public function addError(string $attribute, string $message) {
		$this->errors[$attribute][] = $message;
	}

	private function addErrorForValidation(string $attribute, string $rule, $params = []) {
		$message = $this->errorMessages()[$rule] ?? '';
		foreach ($params as $key => $value) {
			$message = str_replace("{{$key}}", $value, $message);
		}
		$this->errors[$attribute][] = $message;
	}

	public function errorMessages() {
		return [
			self::RULE_REQUIRED => 'This field is required',
			self::RULE_EMAIL =>'This is not a valid email',
			self::RULE_MIN => 'Min length of this field must be {min}',
			self::RULE_MAX => "Max length of this field must be {max}",
			self::RULE_MATCH =>'This field must be the same as {match}',
			self::RULE_UNIQUE =>'This {field} is already exists'
		];
	}

	abstract public function rules(): array; 

	public function hasError($attribute) {
		return $this->errors[$attribute] ?? false;
	}

	public function getFirstError($attribute) {
		return $this->errors[$attribute][0];
	}

	public function labels() {
		return [];
	}

	public function getLabel($attribute) {
		return $this->labels()[$attribute] ?? $attribute;
	}
}