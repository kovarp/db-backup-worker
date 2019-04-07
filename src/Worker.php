<?php declare(strict_types=1);

namespace kovarp\DbBackupWorker;

class Worker {

	private $name;

	private $user;

	private $password;

	private $host;

	private $secret;

	public function __construct(string $name, string $user, string $password, string $host, string $secret) {
		$this->name = $name;
		$this->user = $user;
		$this->password = $password;
		$this->host = $host;
		$this->secret = $secret;
	}

	public function dump() {
		$db = new \mysqli(
			$this->host,
			$this->user,
			$this->password,
			$this->name
		);

		$dump = new \MySQLDump($db);

		$dump->save(__DIR__ . '/../' . sha1('dump' . $this->secret) . '.sql');
	}
}