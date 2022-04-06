<?php
namespace app\core;

abstract class DbModel extends Model
{
	abstract public function tableName(): string;
	abstract public function attributes(): array;
	
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
}