<?php

session_start(); 

if(!(isset($_SESSION['valid'])))
{
    $_SESSION['refererUrl'] = $_SERVER['REQUEST_URI'];
	@header("Location: login.php");
	exit;
}
elseif($_SESSION['valid'] != 1)
{
    $_SESSION['refererUrl'] = $_SERVER['REQUEST_URI'];
	@header("Location: login.php");
	exit;
}

?>
