<?php
session_start();

$cr=parse_ini_file("../assets/components/credential.ini");
$host=$cr['host'];
$user=$cr['user'];
$pass=$cr['pass'];
$db=$cr['db'];

if(!($sqlhandle=mysqli_connect($host,$user,$pass,$db))){
	die(mysqli_error($sqlhandle));
}

if(isset($_POST['qid'],$_POST['uid'],$_POST['content'],$_POST['submit'])){
	$qid=$_POST['qid'];
	$uid=$_POST['uid'];
	$content=mysqli_real_escape_string($sqlhandle,$_POST['content']);
	unset($_POST['qid'],$_POST['uid'],$_POST['content'],$_POST['submit']);
	if($content!==""){
		$query="INSERT INTO answers(qid,uid,content,answered) VALUES ({$qid},{$uid},'{$content}',utc_timestamp())";
		if(!($reslt=mysqli_query($sqlhandle,$query))){
			die(mysqli_error($sqlhandle));
		}else{
			$query="SELECT q_answered FROM users where uid={$uid}";
			if(!($result=mysqli_query($sqlhandle,$query))){
				die(mysqli_error($sqlhandle));
			}else{
				$answered=mysqli_fetch_assoc($result);
				mysqli_free_result($result);
				if($answered){
					$count=$answered['q_answered'];
					$count++;
					$query="UPDATE users SET q_answered={$count} WHERE uid={$uid}";
					if(!($res=mysqli_query($sqlhandle,$query))){
						die(mysqli_error($sqlhandle));
					}
				}
			}
			
		}
	}	 
}

if(isset($_GET['qid'])){
	$qid=$_GET['qid'];
	$query="SELECT qid,title,content,uid,asked,rank,utc_timestamp() AS utctime FROM questions WHERE qid={$qid}";
	$title_present=true;
	if(!($result=mysqli_query($sqlhandle,$query))){
		die(mysqli_error($sqlhandle));
	}else{
		$ans=mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		if(!$ans){
			$title_present=false;
		}

		// $max_query="SELECT max(qid) as maxId FROM questions";
		// $min_query="SELECT min(qid) as minId FROM questions";

		// if(!($max_q=mysqli_query($sqlhandle,$max_query))){
		// 	echo mysqli_error($sqlhandle);
		// }else{
		// 	$max_assoc=mysqli_fetch_assoc($max_q);
		// 	mysqli_free_result($max_q);
		// 	$max=$max_assoc['maxId'];
		// }
		// if(!($min_q=mysqli_query($sqlhandle,$min_query))){
		// 	echo mysqli_error($sqlhandle);
		// }else{
		// 	$min_assoc=mysqli_fetch_assoc($min_q);
		// 	mysqli_free_result($min_q);
		// 	$min=$min_assoc['minId'];
		// }	
	}
}

require_once '../assets/components/php/functions.php';

?>