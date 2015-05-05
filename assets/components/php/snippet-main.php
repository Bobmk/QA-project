<?php

$sort_field="asked";
if(isset($sort_order)){
	if($sort_order=="votes"){
		$sort_field="rank";
	}
}

$select="SELECT qid,title,uid,rank,asked FROM questions ORDER BY $sort_field desc LIMIT $q_start,$q_no";

if(!($result=mysqli_query($sqlhandle,$select))){
	die(mysqli_error($sqlhandle));
}

while($row=mysqli_fetch_assoc($result)){
	$query="SELECT count(*) FROM answers WHERE qid={$row['qid']}";
	$answer=0;
	if(!($search=mysqli_query($sqlhandle, $query))){
		die(mysqli_error($sqlhandle));
	}else{
		$ans=mysqli_fetch_assoc($search);
		mysqli_free_result($search);
		$answer=$ans['count(*)'];
	}
?>
	<!-- <div class="hrow"></div> -->
	<section class="panel panel-default ques-shown">
		<div class="panel-body">
			<div class="col-xs-6 col-sm-1">
				<p class="text-center">Votes <?php echo $row['rank']; ?></p>
			</div>
			<div class="col-xs-6 col-sm-1">
				<p class="text-center">Answers <?php echo $answer ?></p>
			</div>
			<a href="questions?qid=<?php echo $row['qid']; ?>" class="h4 col-xs-12 col-sm-6 col-md-7 col-sm-offset-1 col-md-offset-0"><?php echo $row['title']; ?></a><br>
			<div class="pull-right small col-sm-3">
				<?php
					$name="SELECT uname FROM users WHERE uid={$row['uid']}";
					$res=mysqli_query($sqlhandle,$name);
					$usr=mysqli_fetch_assoc($res);
					mysqli_free_result($res);
					if($usr){
						echo $usr['uname']."<br>";
					}
					echo "asked ".$row['asked'];
				?>
			</div>
		</div>
	</section>
	<!-- <p><?php// echo $row['content']; ?></p> -->

<?php
}
mysqli_free_result($result);
?>