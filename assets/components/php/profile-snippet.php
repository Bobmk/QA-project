<?php
session_start();
require_once "../assets/components/php/sql-connect.php";
require_once "../assets/components/php/functions.php";

if(isset($_SESSION['user_name'],$_SESSION['user_id'])){
	if($_SESSION['user_name']!=="" && $_SESSION['user_id']!==""){
		$query="SELECT * FROM users WHERE uid={$_SESSION['user_id']}";
		if(!($res=mysqli_query($sqlhandle,$query))){
			die(mysqli_error($sqlhandle));
		}
		$result=mysqli_fetch_assoc($res);
		$_SESSION['user_name']=$result['uname'];
		mysqli_free_result($res);
	}else{
		redirect_to('/login/');
	}
}else{
	redirect_to('/login/');
}

?>