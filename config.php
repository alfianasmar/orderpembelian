<?php
	define('DS', DIRECTORY_SEPARATOR);
	$httpHost=$_SERVER['HTTP_HOST'];
	if (strpos($httpHost,'localhost')!==false) {
		define('BASE_URL','http://'.$httpHost.DS.'ordespembelian'.DS);
	}else{
		define('BASE_URL','http://'.$httpHost.DS);
	}
	define('BASE_PATH', __DIR__ . DS);
	define('ASSET_URL', BASE_URL.'assets'.DS);

	define('DB_HOST', 'localhost');
	define('DB_NAME', 'op');
	define('DB_USER', 'root');
	define('DB_PASS', '');
?>
