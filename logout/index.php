<?php
require_once "../assets/components/php/functions.php" ;
session_start();
$_SESSION=array();

if(isset($_COOKIE[session_name()])){
	setcookie(session_name(),null,time()-42000);
}

session_destroy();
redirect_to('/');
?>