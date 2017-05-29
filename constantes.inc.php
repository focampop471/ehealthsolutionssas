<?php
error_reporting(E_ALL);
ini_set("max_execution_time",	0);
setlocale(LC_ALL, 'es_ES');
set_time_limit(0);
define("ROOT_DIR",				"C:/AppServ/www/ehealthsolutionssas/");
define("ROOT_DIR_INCLUDES",		ROOT_DIR."includes/");
define("ROOT_DIR_CLASES",		ROOT_DIR."clases/");
define("ROOT_DIR_ADODB",		ROOT_DIR."includes/adodb5/");
define("HTTP_DIRECTORY",		"http://localhost/ehealthsolutionssas/");
define("HTTP_DIRECTORY_IMG",	HTTP_DIRECTORY."img/");
define("DB_HOST",				"localhost");
define("DB_USER",				"root");
define("DB_PASS",				"indra");
define("DB_NAME",				"ehealthsolutions");
define("COOKIE_NAME",			"ehealthsolutions");
define("COOKIE_TIME",			(time() + (60 * 60)));
?>
