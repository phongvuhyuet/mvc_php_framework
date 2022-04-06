<?php
namespace app\core;

abstract class DbModel extends Model
{
	abstract public function tableName(): string;
	abstract public function attributes(): array;
	abstract public function primaryKey(): string;
	
	public function save() {
		$tableName = $this->tableName();
		$attributes = $this->attributes();
		$params = array_map(fn($attr) => ":$attr", $attributes);
		$statement = Application::$app->database->prepare("insert into $tableName (". 
			implode(',', $attributes)
		
		.") values (". implode(',', $params) ." )");
		foreach ($attributes as $attr) {
			$statement->bindValue(":$attr", $this->{$attr});
		}
		$statement->execute();
		return true;
	}
	public static function findOne($where)  {
		$keys = array_keys($where);
		$sql = array_map(fn ($key) => "$key = :$key", $keys);
		$sql = implode("and", $sql);
		$tableName = static::tableName();
		$statement = Application::$app->database->prepare("select * from $tableName where $sql");

		foreach ($where as $key => $value) {
			$statement->bindValue(":$key", $value);
		}
		$statement->execute();
		return $statement->fetchObject(static::class);
	}
}