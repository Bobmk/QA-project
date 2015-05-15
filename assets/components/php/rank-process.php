<?php

require_once "sql-connect.php";

if(isset($_POST['question_up'],$_POST['user'])){
	$ques_id=$_POST['question_up'];
	$usr_id=$_POST['user'];
	unset($_POST['question_up'],$_POST['user']);

	$search="SELECT uid FROM questions_voted WHERE qid=$ques_id";
	if(!($result=mysqli_query($sqlhandle, $search))){
		die(mysqli_error($sqlhandle));
	}else{
		while($ans=mysqli_fetch_assoc($result)){
			if($ans['uid']==$usr_id){
				echo "voted";
				exit;
			}
		}
	}

	$query="SELECT rank,uid FROM questions where qid=$ques_id";
	if(!($result=mysqli_query($sqlhandle, $query))){
		die(mysqli_error($sqlhandle));
	}else{
		$res=mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		if($res){
			if($res['uid']==$usr_id){
				echo "owner";
				exit;
			}
			$vote=$res['rank'];
			$vote++;
			$query="INSERT INTO questions_voted(uid,qid) VALUES($usr_id,$ques_id)";
			if(!$result=mysqli_query($sqlhandle, $query)){
				die(mysqli_error($sqlhandle));
			}else{
				$query="UPDATE questions SET rank=$vote WHERE qid=$ques_id";
				if(!($result=mysqli_query($sqlhandle, $query))){
					die(mysqli_error($sqlhandle));
				}else{
					echo $vote;					
				}
			}
		}
	}
}

if(isset($_POST['question_down'],$_POST['user'])){
	$ques_id=$_POST['question_down'];
	$usr_id=$_POST['user'];
	unset($_POST['question_down']);

	$search="SELECT uid FROM questions_voted WHERE qid=$ques_id";
	if(!($result=mysqli_query($sqlhandle, $search))){
		die(mysqli_error($sqlhandle));
	}else{
		while($ans=mysqli_fetch_assoc($result)){
			if($ans['uid']==$usr_id){
				echo "voted";
				exit;
			}
		}
	}

	$query="SELECT rank,uid FROM questions where qid=$ques_id";
	if(!($result=mysqli_query($sqlhandle, $query))){
		die(mysqli_error($sqlhandle));
	}else{
		$res=mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		if($res){
			if($res['uid']==$usr_id){
				echo "owner";
				exit;
			}
			$vote=$res['rank'];
			$vote--;
			$query="INSERT INTO questions_voted(uid,qid) VALUES($usr_id,$ques_id)";
			if(!$result=mysqli_query($sqlhandle, $query)){
				die(mysqli_error($sqlhandle));
			}else{
				$query="UPDATE questions SET rank=$vote WHERE qid=$ques_id";
				if(!($result=mysqli_query($sqlhandle, $query))){
					die(mysqli_error($sqlhandle));
				}else{
					echo $vote;					
				}
			}
		}
	}
}

if(isset($_POST['ans_up'],$_POST['ans_qid'],$_POST['ans_uid'],$_POST['ans_ans'],$_POST['ans_usr'])){
	$ans_qid=$_POST['ans_qid'];
	$ans_uid=$_POST['ans_uid'];
	$ans_ans=$_POST['ans_ans'];
	$ans_usr=$_POST['ans_usr'];
	unset($_POST['ans_up'],$_POST['ans_qid'],$_POST['ans_uid'],$_POST['ans_ans'],$_POST['ans_usr']);

	$search="SELECT vote_usr_id FROM answers_voted WHERE qid=$ans_qid AND uid=$ans_uid AND answered='$ans_ans'";
	if(!$res=mysqli_query($sqlhandle, $search)){
		die(mysqli_error($sqlhandle));
	}else{
		while($ans=mysqli_fetch_assoc($res)){
			if($ans['vote_usr_id']==$ans_usr){
				echo "voted";
				exit;
			}
		}
	}

	$query="SELECT rank FROM answers WHERE qid=$ans_qid AND uid=$ans_uid AND answered='$ans_ans'";
	if(!($result=mysqli_query($sqlhandle, $query))){
		die(mysqli_error($sqlhandle));
	}else{
		$res=mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		if($res){
			$vote=$res['rank'];
			$vote++;
			$query="INSERT INTO answers_voted(qid,uid,answered,vote_usr_id) VALUES($ans_qid,$ans_uid,'{$ans_ans}',$ans_usr)";
			if(!$res=mysqli_query($sqlhandle, $query)){
				die(mysqli_error($sqlhandle));
			}else{
				$query="UPDATE answers SET rank=$vote WHERE qid=$ans_qid AND uid=$ans_uid AND answered='$ans_ans'";
				if(!($result=mysqli_query($sqlhandle, $query))){
					die(mysqli_error($sqlhandle));
				}else{
					echo $vote;
				}
			}
		}
	}
}

if(isset($_POST['ans_down'],$_POST['ans_qid'],$_POST['ans_uid'],$_POST['ans_ans'],$_POST['ans_usr'])){
	$ans_qid=$_POST['ans_qid'];
	$ans_uid=$_POST['ans_uid'];
	$ans_ans=$_POST['ans_ans'];
	$ans_usr=$_POST['ans_usr'];
	unset($_POST['ans_down'],$_POST['ans_qid'],$_POST['ans_uid'],$_POST['ans_ans'],$_POST['ans_usr']);

	$search="SELECT vote_usr_id FROM answers_voted WHERE qid=$ans_qid AND uid=$ans_uid AND answered='$ans_ans'";
	if(!$res=mysqli_query($sqlhandle, $search)){
		die(mysqli_error($sqlhandle));
	}else{
		while($ans=mysqli_fetch_assoc($res)){
			if($ans['vote_usr_id']==$ans_usr){
				echo "voted";
				exit;
			}
		}
	}

	$query="SELECT rank FROM answers WHERE qid=$ans_qid AND uid=$ans_uid AND answered='$ans_ans'";
	if(!($result=mysqli_query($sqlhandle, $query))){
		die(mysqli_error($sqlhandle));
	}else{
		$res=mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		if($res){
			$vote=$res['rank'];
			$vote--;
			$query="INSERT INTO answers_voted(qid,uid,answered,vote_usr_id) VALUES($ans_qid,$ans_uid,'{$ans_ans}',$ans_usr)";
			if(!$res=mysqli_query($sqlhandle, $query)){
				die(mysqli_error($sqlhandle));
			}else{
				$query="UPDATE answers SET rank=$vote WHERE qid=$ans_qid AND uid=$ans_uid AND answered='$ans_ans'";
				if(!($result=mysqli_query($sqlhandle, $query))){
					die(mysqli_error($sqlhandle));
				}else{
					echo $vote;					
				}
			}
		}
	}
}