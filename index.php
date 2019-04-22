<?php

/**
 * Error codes:
 * 0 - no error
 * 1 - invalid auth code
 * 2 - cannot connect to database
 */

error_reporting(0);

require_once __DIR__ . '/config.php';

$data = [];

$data['error'] = 0;

if (!isset($_GET['auth']) || empty($_GET['auth']) || $_GET['auth'] !== $config['auth']) {
	$data['error'] = 1;
	$data['errorCode'] = 1;
} else {
	require_once __DIR__ . '/vendor/autoload.php';

	$worker = new \kovarp\DbBackupWorker\Worker(
		$config['name'],
		$config['user'],
		$config['password'],
		$config['host'],
		$config['secret']
	);

	$worker->dump();

	if ($worker->hasError()) {
		$data['error'] = 1;
		$data['errorCode'] = $worker->getErrorCode();
	}
}

header('Content-type: application/json');
echo json_encode( $data );