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

if(isset($_GET['term']) && !empty($_GET['term'])){
	$term=mysqli_real_escape_string($sqlhandle,trim($_GET['term']));
	unset($_GET['term']);
}else{
	$redir=$_SERVER['HTTP_REFERER'];
	if($redir=="http://".$_SERVER['HTTP_HOST']."search/index.php"){
		$redir="/";
	}
	redirect_to("$redir");
}

$q_no=20; // no of questions show per page
$q_start=0;
$page=1;
if(isset($_GET['p'])){
	$page=$_GET['p'];
	unset($_GET['p']);
	$q_start=$q_no*($page-1);
}

$page_count=1; // it will be the no of calculated pages

$range=4; // maximum no of buttons with number shown in pagination

$query="SELECT * FROM questions WHERE MATCH(title,content) AGAINST('$term' WITH QUERY EXPANSION) LIMIT $q_start,$q_no";
if(!$result=mysqli_query($sqlhandle,$query)){
	die(mysqli_error($sqlhandle));
}

$query="SELECT CEIL(COUNT(*)/$q_no) cnt FROM questions WHERE MATCH(title,content) AGAINST('$term' WITH QUERY EXPANSION)";
if(!($p_cnt=mysqli_query($sqlhandle, $query))){
	echo mysqli_error($sqlhandle);
}else{
	$res=mysqli_fetch_assoc($p_cnt);
	mysqli_free_result($p_cnt);
	$page_count=$res['cnt'];
}

$encoded_term=urlencode($term);
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
				?>							
								
						<section>
							<nav>
								<ul class="pagination">
									<li
										<?php
											if($page==1){
												echo "class=\"disabled\"";
											}
										?>
									><a href="/search?term=<?php echo $encoded_term; ?>"><span aria-hidden="true" class="glyphicon glyphicon-fast-backward"></span></a></li>
									<li
										<?php
											if($page==1){
												echo "class=\"disabled\"";
											}
										?>
									><a href="/search?term=<?php echo $encoded_term; ?>&p=<?php echo $page-1; ?>"><span aria-hidden="true" class="glyphicon glyphicon-step-backward"></span></a></li>
									<?php
										if($page>1 && $page_count>$range){
									?>
										<li><a>...</a></li>
									<?php
										}
									?>
									<?php
										if($page>$page_count-$range){
											$mod_start=$page_count-$range+1;
											if($mod_start<1){
												$mod_start=1;
											}
											for($i=$mod_start;$i<=$page_count;$i++){
									?>
												<li
													<?php
														if($i==$page){
															echo "class=\"active\"";
														}
													?>
												><a href="/search?term=<?php echo $encoded_term; ?>&p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
									<?php
											}
										}else{ 
											for($i=$page,$range=1;$i<=$page_count;$i++,$range++){
									?>
											<li
												<?php
													if($i==$page){
														echo "class=\"active\"";
													}
												?>
											><a href="/search?term=<?php echo $encoded_term; ?>&p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
									<?php
												if($range==4){
													break;
												}
											}
										}
									?>
									<?php
										if($page<=$page_count-$range){
									?>
										<li><a>...</a></li>
									<?php
										}
									?>
									<li
										<?php
											if($page==$page_count){
												echo "class=\"disabled\"";
											}
										?>
									><a href="/search?term=<?php echo $encoded_term; ?>&p=<?php echo $page+1; ?>"><span aria-hidden="true" class="glyphicon glyphicon-step-forward"></span></a></li>
									<li
										<?php
											if($page==$page_count){
												echo "class=\"disabled\"";
											}
										?>
									><a href="/search?term=<?php echo $encoded_term; ?>&p=<?php echo $page_count; ?>"><span aria-hidden="true" class="glyphicon glyphicon-fast-forward"></span></a></li>
								</ul>
							</nav>
						</section>
				<?php
					}else{
				?>
					<p class="col-sm-offset-1 h3">
						No data found
					</p>
				<?php
					}
				?>
			</section>

		<?php include_once "../assets/components/php/scripts-tag.php"; ?>
	</body>
</html>