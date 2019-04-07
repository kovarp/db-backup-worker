<?php

/**
 * Error codes:
 * 0 - no error
 * 1 - invalid auth code
 * 2 - cannot connect to database
 */

error_reporting(0);

$data = [];

$data['error'] = 0;

if (!isset($_GET['auth']) || empty($_GET['auth']) || $_GET['auth'] !== '') {
	$data['error'] = 1;
	$data['errorCode'] = 1;
} else {
	require_once __DIR__ . '/vendor/autoload.php';

	$worker = new \kovarp\DbBackupWorker\Worker(
		'',
		'',
		'',
		'localhost',
		''
	);

	$worker->dump();

	if ($worker->hasError()) {
		$data['error'] = 1;
		$data['errorCode'] = $worker->getErrorCode();
	}
}

header('Content-type: application/json');
echo json_encode( $data );