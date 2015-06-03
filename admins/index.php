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

if(isset($_POST['user'],$_POST['submit'])){
	$u_term=mysqli_real_escape_string($sqlhandle, trim($_POST['user']));
	unset($_POST['user'],$_POST['submit']);
}

$query="SELECT uid,uname,admin,superadmin FROM users";

if(isset($u_term)){
	$query.=" WHERE uname RLIKE '.*$u_term.*'";
}
$query.=" ORDER BY superadmin DESC,admin DESC,uname LIMIT $q_start,$q_no";

$count_query="SELECT COUNT(*) cnt FROM users";
if(isset($u_term)){
	$count_query.=" WHERE name RLIKE '.*$u_term.*'";
}

if(!$result=mysqli_query($sqlhandle, $query)){
	die(mysqli_error($sqlhandle));
}else{
	if($res=mysqli_query($sqlhandle, $count_query)){
		$val=mysqli_fetch_assoc($res);
		mysqli_free_result($res);
		$count=$val['cnt'];
		$page_count=ceil($count/$q_no);
	}
}

?>
<!doctype html>
<html>
	<head>
		<title>Admins - Q &amp; A</title>
		<?php require_once '../assets/components/php/head-tag.php'; ?>
	</head>
	<body>
		<?php require_once "../assets/components/php/snippet-header.php"; ?>

		<div class="container">
			<h2>Admins</h2><br>
			<form id="user_search" class="pull-right form-inline" action="" method="POST" role="form">
				<input type="search" id="user_name" name="user" placeholder="Search User">
				<button type="submit" name="submit" value="submit" class="btn btn-default btn-sm">Search</button>
			</form>
			<br><br>
			<div class="hrow"></div>
			<div class="col-md-8">
				<?php
					if(mysqli_num_rows($result)){
						while($row=mysqli_fetch_assoc($result)){
				?>
							<div class="clearfix">
								<?php echo $row['uname']; ?>
								<?php
								if(isset($_SESSION['superadmin']) && $_SESSION['superadmin']){
									if($row['superadmin']){
								?>
										<span class="pull-right">Super admin</span>
								<?php
									}else if($row['admin']){
								?>
										<form action="/assets/components/php/process-admin.php" method="POST" role="form" class="pull-right">
											<input type="hidden" name="uid" value="<?php echo $row['uid']; ?>">
											<input type="hidden" name="remove" value="true">
											<button type="submit" name="submit" value="submit" class="btn btn-danger">Remove admin</button>
										</form>
								<?php
									}else{
								?>
										<form action="/assets/components/php/process-admin.php" method="POST" role="form" class="pull-right">
											<input type="hidden" name="uid" value="<?php echo $row['uid']; ?>">
											<input type="hidden" name="add" value="true">
											<button type="submit" name="submit" value="submit" class="btn btn-success">Make admin</button>
										</form>
								<?php
									}
								}else{
									if($row['superadmin']){
								?>
										<span class="pull-right">Super admin</span>
								<?php
									}else if($row['admin']){
								?>
										<span class="pull-right">Admin</span>
								<?php
									}else{
								?>
										<span class="pull-right">User</span>
								<?php
									}
								}
								?>
							</div><br>
				<?php
						}
						mysqli_free_result($result);
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
										><a href="/admins"><span aria-hidden="true" class="glyphicon glyphicon-fast-backward"></span></a></li>
										<li
											<?php
												if($page==1){
													echo "class=\"disabled\"";
												}
											?>
										><a href="/admins?p=<?php echo $page-1; ?>"><span aria-hidden="true" class="glyphicon glyphicon-step-backward"></span></a></li>
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
													><a href="/admins?p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
												><a href="/admins?p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
										><a href="/admins?p=<?php echo $page+1; ?>"><span aria-hidden="true" class="glyphicon glyphicon-step-forward"></span></a></li>
										<li
											<?php
												if($page==$page_count){
													echo "class=\"disabled\"";
												}
											?>
										><a href="/admins?p=<?php echo $page_count; ?>"><span aria-hidden="true" class="glyphicon glyphicon-fast-forward"></span></a></li>
									</ul>
								</nav>
							</section>

							<a class="btn" id="toTop"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></a>
				<?php
					}else{
				?>
					<p class="col-sm-offset-1 h3">
						No user found
					</p>
				<?php
					}
				?>
			</div>
		</div>
	<?php require_once "../assets/components/php/scripts-tag.php"; ?>
	<script src="/assets/js/admin.js"></script>
	</body>
	<?php require_once "../assets/components/php/sql-disconnect.php"; ?>
</html>