<?php

session_start();
session_destroy();

session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header("Location: home/");
	exit();
}

require_once('inc/config.php');
require_once(ROOT_PATH . 'inc/database.php');
include(ROOT_PATH . 'inc/header.php');
include(ROOT_PATH . 'inc/footer.php')
?>