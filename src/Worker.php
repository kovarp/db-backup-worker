<?php declare(strict_types=1);

namespace kovarp\DbBackupWorker;

class Worker {

	private $name;

	private $user;

	private $password;

	private $host;

	public function __construct(string $name, string $user, string $password, string $host = 'localhost') {
		$this->name = $name;
		$this->user = $user;
		$this->password = $password;
		$this->host = $host;
	}

	public function dump() {
		$db = new \mysqli(
			$this->host,
			$this->user,
			$this->password,
			$this->name
		);

		$dump = new \MySQLDump($db);

		header('Content-Type: application/sql');
		header('Content-Disposition: attachment; filename="' . date('Y-m-d-H-i-s') . '.sql"');
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-cache');
		header('Connection: close');

		$dump->write();
	}
}