<?php 
session_start();
$cr=parse_ini_file("../credential.ini");
$host=$cr['host'];
$user=$cr['user'];
$pass=$cr['pass'];
$db=$cr['db'];

if(!($sqlhandle=mysqli_connect($host,$user,$pass,$db))){
	echo "Error connecting to database";
}
require_once "functions.php";

$entered_name="";

if(isset($_POST['username'],$_POST['email'],$_POST['password'],$_POST['submit'])){

	$email=mysqli_real_escape_string($sqlhandle,trim($_POST['email']));
	$entered_name=mysqli_real_escape_string($sqlhandle,trim($_POST['username']));
	$password=$_POST['password'];
	unset($_POST['username'],$_POST['email'],$_POST['password'],$_POST['submit']);
	
	$search="SELECT * FROM users WHERE login='{$email}'";

	if(!$res=mysqli_query($sqlhandle,$search)){
		echo mysqli_error($sqlhandle);
	}
	$answer=mysqli_fetch_assoc($res);
	mysqli_free_result($res);
	if($answer){		
		$_SESSION['errmsg']="this email is already registered";
		mysqli_close($sqlhandle);
		redirect_to('/register/');
	}else{		
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

}