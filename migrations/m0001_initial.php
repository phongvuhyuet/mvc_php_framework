<?php

use app\core\Application;

class m0001_initial {
	public function up() {
		$db = Application::$app->database;
		$SQL = "create table users (
				id int auto_increment primary key,
				email varchar(255) not null,
				firstName varchar(255) not null,
				lastName varchar(255) not null,
				status tinyint not null,
				created_at timestamp default current_timestamp
			) engine = innodb;";
		$db->pdo->exec($SQL);
	}
	public function down() {
			$db = Application::$app->database;
		$SQL = "drop table users;";
		$db->pdo->exec($SQL);	
	}
}