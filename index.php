<?php

if (!isset($_GET['auth']) || empty($_GET['auth']) || $_GET['auth'] !== '') {
	die('Invalid auth token');
}

require_once __DIR__ . '/vendor/autoload.php';

$worker = new \kovarp\DbBackupWorker\Worker(
	'',
	'',
	''
);

$worker->dump();