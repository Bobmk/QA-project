<?php

require_once "sql-connect.php";

if(isset($_POST['question_up'])){
	$ques_id=$_POST['question_up'];
	unset($_POST['question_up']);
	$query="SELECT rank FROM questions where qid=$ques_id";
	if(!($result=mysqli_query($sqlhandle, $query))){
		// echo mysqli_error($sqlhandle);
	}else{
		$res=mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		if($res){
			$vote=$res['rank'];
			$vote++;
			$query="UPDATE questions SET rank=$vote WHERE qid=$ques_id";
			if(!($result=mysqli_query($sqlhandle, $query))){
				// echo mysqli_error($sqlhandle);
			}else{
				echo $vote;
			}
		}
	}
}

if(isset($_POST['question_down'])){
	$ques_id=$_POST['question_down'];
	unset($_POST['question_down']);
	$query="SELECT rank FROM questions where qid=$ques_id";
	if(!($result=mysqli_query($sqlhandle, $query))){
		// echo mysqli_error($sqlhandle);
	}else{
		$res=mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		if($res){
			$vote=$res['rank'];
			$vote--;
			$query="UPDATE questions SET rank=$vote WHERE qid=$ques_id";
			if(!($result=mysqli_query($sqlhandle, $query))){
				// echo mysqli_error($sqlhandle);
			}else{
				echo $vote;
			}
		}
	}
}

if(isset($_POST['ans_up'],$_POST['ans_qid'],$_POST['ans_uid'],$_POST['ans_ans'])){
	$ans_qid=$_POST['ans_qid'];
	$ans_uid=$_POST['ans_uid'];
	$ans_ans=$_POST['ans_ans'];
	unset($_POST['ans_up'],$_POST['ans_qid'],$_POST['ans_uid'],$_POST['ans_ans']);
	$query="SELECT rank FROM answers WHERE qid=$ans_qid AND uid=$ans_uid AND answered='$ans_ans'";
	if(!($result=mysqli_query($sqlhandle, $query))){
		// echo mysqli_error($sqlhandle);
	}else{
		$res=mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		if($res){
			$vote=$res['rank'];
			$vote++;
			$query="UPDATE answers SET rank=$vote WHERE qid=$ans_qid AND uid=$ans_uid AND answered='$ans_ans'";
			if(!($result=mysqli_query($sqlhandle, $query))){
				// echo mysqli_error($sqlhandle);
			}else{
				echo $vote;
			}
		}
	}
}

if(isset($_POST['ans_down'],$_POST['ans_qid'],$_POST['ans_uid'],$_POST['ans_ans'])){
	$ans_qid=$_POST['ans_qid'];
	$ans_uid=$_POST['ans_uid'];
	$ans_ans=$_POST['ans_ans'];
	unset($_POST['ans_down'],$_POST['ans_qid'],$_POST['ans_uid'],$_POST['ans_ans']);
	$query="SELECT rank FROM answers WHERE qid=$ans_qid AND uid=$ans_uid AND answered='$ans_ans'";
	if(!($result=mysqli_query($sqlhandle, $query))){
		// echo mysqli_error($sqlhandle);
	}else{
		$res=mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		if($res){
			$vote=$res['rank'];
			$vote--;
			$query="UPDATE answers SET rank=$vote WHERE qid=$ans_qid AND uid=$ans_uid AND answered='$ans_ans'";
			if(!($result=mysqli_query($sqlhandle, $query))){
				// echo mysqli_error($sqlhandle);
			}else{
				echo $vote;
			}
		}
	}
}