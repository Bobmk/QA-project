<?php 
session_start();

require_once "functions.php";
require_once "sql-connect.php";

$target_page=false;
if(isset($_POST['qid'])){
	$target_page=true;
	$tpqid=$_POST['qid'];
	unset($_POST['qid']);
}


if(isset($_POST['login'],$_POST['password'],$_POST['submit'])){
	$email=$_POST['login'];
	$password=$_POST['password'];
	unset($_POST['login'],$_POST['password'],$_POST['submit']);

	if($email!=="" && $password!==""){
		$email=mysqli_real_escape_string($sqlhandle,$email);
		
		$search="SELECT * FROM users WHERE login='{$email}'";
		if(!$res=mysqli_query($sqlhandle,$search)){
			$_SESSION['errmsg']=mysqli_error($sqlhandle);
			redirect_to('/login/');
		}else{
			$result=mysqli_fetch_assoc($res);
			mysqli_free_result($res);
			if($result){
				if(password_check($password,$result['password'])){
					$_SESSION['user_name']=$result['uname'];
					$_SESSION['user_id']=$result['uid'];
					if($target_page){
						if(isset($_SESSION['get_qid'])){
							unset($_SESSION['get_qid']);
						}
						redirect_to("/questions?qid={$tpqid}");
					}else{
						redirect_to('/');
					}
				}else{
					$_SESSION['errmsg']="username/password do not match";
					redirect_to('/login/');
				}

			}else{
				$_SESSION['errmsg']="username/password do not match";
				redirect_to('/login/');
			}
		}
	}else{
		$_SESSION['errmsg']="must enter username/password";
		redirect_to('/login/');
	}
}else{
	redirect_to('/login');
}
