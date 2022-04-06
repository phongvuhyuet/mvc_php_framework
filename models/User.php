<?php
namespace app\models;

use app\core\DbModel;
use app\core\Model;
use app\core\UserModel;

class User extends UserModel
{
	protected const STATUS_INACTIVE = 0;
	protected const STATUS_ACTIVE = 1;
	protected const STATUS_DELETED = 2;
	

	public string $firstName = '';
	public string $lastName = '';
	public string $email = '';
	public string $password = '';
	public string $confirmPassword = '';
	public int $status = self::STATUS_INACTIVE;	

	public function save() {
		$this->status = self::STATUS_ACTIVE;
		$this->password = password_hash($this->password, PASSWORD_DEFAULT);
		return parent::save();
	}

	public function rules(): array {
		return [
			'firstName' => [self::RULE_REQUIRED],
			'lastName' => [self::RULE_REQUIRED],
			'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class, 'field' => 'email']],
			'password' => [self::RULE_REQUIRED, 
			[self::RULE_MAX, 'max' => 24], [self::RULE_MIN, 'min' => 8]
		],
			'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
	];
	}
	public function tableName(): string {
		return 'users';
	}

	public function attributes(): array
	{
		return [
			'email',
			'firstName', 
			'lastName',
			'status',
			'password'
		];
	}

	public function labels() {
		return [
			'email' => 'Email',
			'firstName' =>'First Name',
			'lastName' => 'Last Name',
			'password' => 'Password',
			'confirmPassword' => 'Confirm Password'
		];
	}

	public function primaryKey(): string
	{
		return 'id';
	}

	public function getDisplayName(): string
	{
		return $this->firstName . ' ' . $this->lastName;

	}
}
