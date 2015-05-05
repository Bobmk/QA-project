<?php 

require_once "sql-connect.php";
require_once "functions.php";

if(isset($_POST['title'],$_POST['content'],$_POST['uid'],$_POST['submit'])){
	$title=$_POST['title'];
	$content=$_POST['content'];
	$uid=$_POST['uid'];
	unset($_POST['title'],$_POST['content'],$_POST['uid'],$_POST['submit']);

	if($title!=="" && $content!==""){
		$title=mysqli_real_escape_string($sqlhandle,trim($title));
		$content=mysqli_real_escape_string($sqlhandle,$content);

		$query="INSERT INTO questions(title,content,uid,asked) VALUES('{$title}','{$content}',{$uid},utc_timestamp())";

		if(!($res=mysqli_query($sqlhandle,$query))){
			die(mysqli_error($sqlhandle));
		}else{
			$qry="SELECT q_asked FROM users WHERE uid=$uid";
			if(!($result=mysqli_query($sqlhandle,$qry))){
				die(mysqli_error($sqlhandle));
			}else{
				$ans=mysqli_fetch_assoc($result);
				mysqli_free_result($result);
				$count=$ans['q_asked'];
				$count++;
				$query="UPDATE users SET q_asked={$count} WHERE uid={$uid}";
				if(!($res=mysqli_query($sqlhandle,$query))){
					die(mysqli_error($sqlhandle));
				}
			}
			redirect_to('/');
		}
	}
}else{
	redirect_to('/ask');
}