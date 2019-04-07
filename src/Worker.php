<?php declare(strict_types=1);

namespace kovarp\DbBackupWorker;

class Worker {

	private $name;

	private $user;

	private $password;

	private $host;

	private $secret;

	private $errorCode = 0;

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

		if ($db->connect_errno) {
			$this->setErrorCode(2);
		} else {
			$dump = new \MySQLDump($db);

			$dump->save(__DIR__ . '/../' . sha1('dump' . $this->secret) . '.sql');
		}
	}

	public function hasError() {
		return ($this->errorCode !== 0);
	}

	public function setErrorCode($errorCode) {
		$this->errorCode = $errorCode;
	}

	public function getErrorCode() {
		return $this->errorCode;
	}
}