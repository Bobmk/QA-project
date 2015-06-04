<?php
require_once 'sql-connect.php';
require_once 'functions.php';

if(isset($_POST['uid'],$_POST['add'],$_POST['submit'])){
	$uid=$_POST['uid'];
	unset($_POST['uid'],$_POST['add'],$_POST['submit']);
	$query="UPDATE users SET admin=TRUE WHERE uid=$uid";
	if(!$res=mysqli_query($sqlhandle, $query)){
		die(mysqli_error($sqlhandle));
	}
	redirect_to('/admins');
}

if(isset($_POST['uid'],$_POST['remove'],$_POST['submit'])){
	$uid=$_POST['uid'];
	unset($_POST['uid'],$_POST['remove'],$_POST['submit']);
	$query="UPDATE users SET admin=FALSE WHERE uid=$uid";
	if(!$res=mysqli_query($sqlhandle, $query)){
		die(mysqli_error($sqlhandle));
	}
	redirect_to('/admins');
}

?>