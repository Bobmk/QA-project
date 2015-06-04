<?php
session_start();
require_once 'sql-connect.php';
require_once 'functions.php';

if(isset($_POST['qid'],$_POST['delete'],$_POST['question'])){
	$qid=$_POST['qid'];
	unset($_POST['qid'],$_POST['delete'],$_POST['question']);
	$query="DELETE FROM questions WHERE qid=$qid";
	if(!($res=mysqli_query($sqlhandle, $query))){
		$_SESSION['errmsg']="there was a problem deleting the question";
		redirect_to("/questions?qid=$qid");
	}
	redirect_to('/');
}

if(isset($_POST['qid'],$_POST['uid'],$_POST['answered'])){
	$qid=$_POST['qid'];
	$uid=$_POST['uid'];
	$answered=$_POST['answered'];
	unset($_POST['qid'],$_POST['uid'],$_POST['answered']);
	$query="DELETE FROM answers WHERE qid=$qid AND uid=$uid AND answered='{$answered}'";
	if(!$res=mysqli_query($sqlhandle, $query)){
		$_SESSION['errmsg']="there was a problem deleting the answer";
	}else{
		$query="DELETE FROM answers_voted WHERE qid=$qid AND uid=$uid AND answered='{$answered}'";
		$res=mysqli_query($sqlhandle, $query);
	}
	redirect_to("/questions?qid=$qid");
}
?>