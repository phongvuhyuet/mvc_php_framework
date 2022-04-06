<?php
namespace app\core;

class Database {
	public \PDO $pdo;

	public function __construct(array $config)
	{
		$config = $config['db'];
		$this->pdo = new \PDO($config['dsn'] ?? '', $config['user'] ?? '', $config['password'] ?? '');
		$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	}

	public function applyMigrations() {
		$this->createMigrationsTable();
		$appliedMigrations = $this->getAppliedMigrations();

		$files = scandir(Application::$ROOT_DIR. '/migrations');
		$toApplyMigrations = array_diff($files, $appliedMigrations);
		foreach ($toApplyMigrations as $migration) {
			if ($migration === '.' || $migration === '..') {
				continue;
			}
			require_once Application::$ROOT_DIR. '/migrations'.  '/'.$migration;
			$className = pathinfo($migration, PATHINFO_FILENAME);
			$this->log( "Applying $migration");
			$instance = new $className();
			$instance->up();
			$this->log( "Applying $migration");
			$newMigrations[] = $migration;
		}
		if (!empty($newMigrations)) {
			$this->saveMigrations($newMigrations);
		} else {
			$this->log( "all applied");
		}

	}
	public function createMigrationsTable() {
		$this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
			id INT AUTO_INCREMENT PRIMARY KEY,
			migration VARCHAR(255),
			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
		) ENGINE=INNODB;");
	}
	public function getAppliedMigrations() {
		$statement = $this->pdo->prepare("SELECT migration FROM migrations");
		$statement->execute();
		return $statement->fetchAll(\PDO::FETCH_COLUMN);
	}
	public function saveMigrations($migration) {
		$migration = implode(",", array_map(fn ($m) => "('$m')", $migration));	
		$statement = $this->pdo->prepare("insert into migrations (migration) values $migration");
		$statement->execute();
	}

	protected function log($message) {
		echo '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL; 
	}

	public function prepare($string) {
		return $this->pdo->prepare($string);
	}
}