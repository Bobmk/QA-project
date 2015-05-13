<?php 
session_start();

require_once "sql-connect.php";
require_once "functions.php";

$entered_name="";

if(isset($_POST['username'],$_POST['email'],$_POST['password'],$_POST['submit'])){

	$email=mysqli_real_escape_string($sqlhandle,trim($_POST['email']));
	$entered_name=mysqli_real_escape_string($sqlhandle,trim($_POST['username']));
	$password=$_POST['password'];
	unset($_POST['username'],$_POST['email'],$_POST['password'],$_POST['submit']);
	
	$search="SELECT * FROM users WHERE login='{$email}'";

	if(!$res=mysqli_query($sqlhandle,$search)){
		die(mysqli_error($sqlhandle));
	}
	$answer=mysqli_fetch_assoc($res);
	mysqli_free_result($res);
	if($answer){		
		$_SESSION['errmsg']="this email is already registered";
		mysqli_close($sqlhandle);
		redirect_to('/register/');
	}

	$search="SELECT * FROM users WHERE uname='{$entered_name}'";
	if(!($res=mysqli_query($sqlhandle,$search))){
		die(mysqli_connect_error());
	}else{
		$answer=mysqli_num_rows($res);
		mysqli_free_result($res);
		if($answer){
			$_SESSION['errmsg']="this username is already taken";
			mysqli_close($sqlhandle);
			redirect_to('/register/');
		}
	}

	$hash_password=password_encrypt($password);
	$query="INSERT INTO users (uname,login,password,joined) VALUES ('{$entered_name}','{$email}','{$hash_password}',utc_date());";
	if(!($result=mysqli_query($sqlhandle,$query))){
		$_SESSION['errmsg']=mysqli_error($sqlhandle);
		mysqli_close($sqlhandle);
		redirect_to('/register/');
	}else{
		mysqli_close($sqlhandle);
		redirect_to('/login/');
	}
}

if(isset($_POST['uname'])){
	$uname=mysqli_real_escape_string($sqlhandle,trim($_POST['uname']));
	$query="SELECT * FROM users WHERE uname='{$uname}'";
	if(!($result=mysqli_query($sqlhandle,$query))){
		die(mysqli_connect_error());
	}else{
		$ans=mysqli_num_rows($result);
		mysqli_free_result($result);
		$uname=[ "present" => false ];
		if($ans){
			$uname['present']=true;
		}
		mysqli_close($sqlhandle);
		echo json_encode($uname);
	}
}