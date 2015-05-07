<?php
	session_start();
require_once '../assets/components/php/functions.php';	

$cr=parse_ini_file("../assets/components/credential.ini");
$host=$cr['host'];
$user=$cr['user'];
$pass=$cr['pass'];
$db=$cr['db'];

if(!($sqlhandle=mysqli_connect($host,$user,$pass,$db))){
	die(mysqli_error($sqlhandle));
}	

if(isset($_POST['term'],$_POST['submit']) && !empty($_POST['term'])){
	$term=mysqli_real_escape_string($sqlhandle,trim($_POST['term']));
	unset($_POST['term'],$_POST['submit']);
	$query="SELECT * FROM questions WHERE MATCH(title,content) AGAINST('$term' WITH QUERY EXPANSION)";
	if(!$result=mysqli_query($sqlhandle,$query)){
		die(mysqli_error($sqlhandle));
	}
}else{
	$redir=$_SERVER['HTTP_REFERER'];
	if($_SERVER['SCRIPT_NAME']=="/search/index.php"){
		$redir="/";
	}
	redirect_to("$redir");
}
?>
<!doctype html>
<html>
	<?php include_once "../assets/components/php/head-tag.php"; ?>
	<title>Search Page</title>
	<body>
		<?php include_once "../assets/components/php/snippet-header.php"; ?>
		
			<section class="container">
					<br><br>
				<?php
					if(mysqli_num_rows($result)){
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
							<section class="panel panel-default ques-shown">
								<div class="panel-body">
									<div class="col-xs-6 col-sm-1">
										<p class="text-center">Votes <?php echo $row['rank']; ?></p>
									</div>
									<div class="col-xs-6 col-sm-1">
										<p class="text-center">Answers <?php echo $answer ?></p>
									</div>
									<a href="/questions?qid=<?php echo $row['qid']; ?>" class="h4 col-xs-12 col-sm-6 col-md-7 col-sm-offset-1 col-md-offset-0"><?php echo $row['title']; ?></a><br>
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
				<?php
						}
					}else{
				?>
					<p class="col-sm-offset-1">
						No data found
					</p>
				<?php
					}
				?>
			</section>

		<?php include_once "../assets/components/php/scripts-tag.php"; ?>
	</body>
</html>