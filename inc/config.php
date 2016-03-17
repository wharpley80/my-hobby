<?php

define("LOCALHOST", $_SERVER["SERVER_NAME"] == "localhost");

if (LOCALHOST) {
	define("BASE_URL", "/my-hobby/");
	define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/my-hobby/");

	define("DB_HOST", "localhost");
	define("DB_NAME", "my_hobby");
	define("DB_PORT", "3306"); 
	define("DB_USER", "root");
	define("DB_PASS", "root");
} else {
	// Production
	define("BASE_URL", "/");
	define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/");
	
	define("DB_HOST", "localhost");
	define("DB_NAME", "collect_snap");
	define("DB_PORT", "3306"); 
	define("DB_USER", "billy1980");
	define("DB_PASS", "wotco712");
}