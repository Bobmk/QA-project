<?php
session_start();

require_once "sql-connect.php";
require_once 'functions.php';

if(isset($_POST['id'],$_POST['pass'])){
	$uid=$_POST['id'];
	$pass=$_POST['pass'];
	$ans=[ "checked" => false ];
	unset($_POST['id'],$_POST['pass']);
	if(!empty($uid) && $pass!==""){
		$qry="SELECT * FROM users WHERE uid={$uid}";
		if($res=mysqli_query($sqlhandle,$qry)){
			$result=mysqli_fetch_assoc($res);
			mysqli_free_result($res);
			if($result){
				$ans["checked"]=password_check($pass,$result['password']);
			}else{
				// $ans["text"]="third checking";
			}
		}else{
			// $ans["text"]="second checking";
	}
	}else{
		// $ans["text"]="first checking";
	}
	mysqli_close($sqlhandle);
	echo json_encode($ans);
}

if(isset($_POST['uid'],$_POST['nuname'],$_POST['submit'])){
	$uid=$_POST['uid'];
	$nuname=mysqli_real_escape_string($sqlhandle,trim($_POST['nuname']));
	unset($_POST['uid'],$_POST['nuname'],$_POST['submit']);

	$search="SELECT * FROM users WHERE uname='{$nuname}'";
	if(!($res=mysqli_query($sqlhandle,$search))){
		die(mysqli_connect_error());
	}else{
		$answer=mysqli_num_rows($res);
		mysqli_free_result($res);
		if($answer){
			$_SESSION['errmsg']="the username you entered is already taken";
			mysqli_close($sqlhandle);
			redirect_to('/users/');
		}
	}

	$query="UPDATE users SET uname='{$nuname}'";
	if(isset($_POST['npass']) && !empty($_POST['npass'])){
		$npass=password_encrypt($_POST['npass']);
		unset($_POST['npass']);
		$query.=",password='{$npass}'";
	}
	$query.=" WHERE uid={$uid}";
	if(!($res=mysqli_query($sqlhandle,$query))){
		die(mysqli_error($sqlhandle));
	}
	$_SESSION['update_success']=mysqli_affected_rows($sqlhandle);

	$query="SELECT * FROM users WHERE uid={$uid}";
	if(!($res=mysqli_query($sqlhandle,$query))){
		die(mysqli_error($sqlhandle));
	}
	$result=mysqli_fetch_assoc($res);
	mysqli_free_result($res);
	mysqli_close($sqlhandle);
	redirect_to('/users/');
}

?>