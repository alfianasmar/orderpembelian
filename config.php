<?php
	define('DS', DIRECTORY_SEPARATOR);
	$httpHost=$_SERVER['HTTP_HOST'];
	if (strpos($httpHost,'localhost')!==false) {
		define('BASE_URL','http://'.$httpHost.DS.'batubata'.DS);
	}else{
		define('BASE_URL','http://'.$httpHost.DS);
	}
	define('BASE_PATH', __DIR__ . DS);
	define('VIEW_PATH', BASE_PATH.'view' . DS);
	define('ASSET_PATH', BASE_URL.'asset'.DS);
	define('UPLOAD_PATH',BASE_PATH.'upload'.DS);
	define('UPLOAD_URL',BASE_URL.'upload'.DS);

	define('DB_HOST', 'localhost');
	define('DB_NAME', 'bb');
	define('DB_USER', 'root');
	define('DB_PASS', '');
?>
