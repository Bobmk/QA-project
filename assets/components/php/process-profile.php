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
	echo json_encode($ans);
}

if(isset($_POST['uid'],$_POST['nuname'],$_POST['submit'])){
	$uid=$_POST['uid'];
	$nuname=mysqli_real_escape_string($sqlhandle,trim($_POST['nuname']));
	unset($_POST['uid'],$_POST['nuname'],$_POST['submit']);
	$query="UPDATE users SET uname='{$nuname}'";
	if(isset($_POST['npass']) && !empty($_POST['npass'])){
		$npass=password_encrypt($_POST['npass']);
		unset($_POST['npass']);
		$query.=",password='{$npass}'";
	}
	$query.=" WHERE uid={$uid}";
	if(!($res=mysqli_query($sqlhandle,$query))){
		echo mysqli_error($sqlhandle);
	}
	$_SESSION['update_success']=mysqli_affected_rows($sqlhandle);

	$query="SELECT * FROM users WHERE uid={$uid}";
	if(!($res=mysqli_query($sqlhandle,$query))){
		echo mysqli_error($sqlhandle);
	}
	$result=mysqli_fetch_assoc($res);
	mysqli_free_result($res);
	redirect_to('/users/');
}

?>