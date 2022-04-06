<?php

use app\core\Application;

class m0002_add_password_to_users_table{
	public function up() {
		$db = Application::$app->database;
		$SQL = "alter table users add column password varchar(255) not null;" ;
		$db->pdo->exec($SQL);
	}
	public function down() {
		$db = Application::$app->database;
		$SQL = "alter table users drop column password; " ;
		$db->pdo->exec($SQL);
	}
}