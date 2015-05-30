<?php session_start(); 

$sort_order="newest"; // sort order of the questions

if(isset($_SESSION['sort'])){
	$sort_order=$_SESSION['sort'];
}

if(isset($_GET['sort'])){
	$sort_order=$_GET['sort'];
	unset($_GET['sort']);
}

$_SESSION['sort']=$sort_order;

$cr=parse_ini_file("assets/components/credential.ini");
$host=$cr['host'];
$user=$cr['user'];
$pass=$cr['pass'];
$db=$cr['db'];

if(!($sqlhandle=mysqli_connect($host,$user,$pass,$db))){
	echo "Error connecting to database";
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

$query="SELECT CEIL(COUNT(*)/$q_no) cnt FROM questions";
if(!($result=mysqli_query($sqlhandle, $query))){
	echo mysqli_error($sqlhandle);
}else{
	$res=mysqli_fetch_assoc($result);
	mysqli_free_result($result);
	$page_count=$res['cnt'];
}

$range=4; // no of buttons shown in pagination

require_once 'assets/components/php/functions.php';
?>
<!DOCTYPE html>
<html>
	<?php include_once "assets/components/php/head-tag.php"; ?>
	<title>Q &amp; A</title>

	<body>
		<?php include_once "assets/components/php/snippet-header.php"; ?>

		
		<div class="container">

			<?php
			if($page<=$page_count){
			?>
			
				<section>
					<section class="pull-right">
						<a href="/ask/" class="btn btn-success ">Ask a question</a>
					</section><br><br>
				</section><br>

				<section role="tabpanel">
					<div class="tabpane clearfix">
						<ul class="nav nav-tabs pull-right" role="tablist">
							<li role="presentation"
								<?php 
									if($sort_order=="newest"){
										echo " class=\"active\"";
									}
								?>
						 	><a href="?sort=newest" role="tab">Newest</a></li>
							<li role="presentation"
								<?php 
									if($sort_order=="votes"){
										echo " class=\"active\"";
									}
								?>
							><a href="?sort=votes" role="tab">Votes</a></li>
						</ul>
					</div><!-- tabpane -->
					<div class="tab-content">
						<?php include_once "assets/components/php/snippet-main.php"; ?>
					</div><!-- tab-content -->
				</section>
				
				<section>
					<nav>
						<ul class="pagination">
							<li
								<?php
									if($page==1){
										echo "class=\"disabled\"";
									}
								?>
							><a href="/"><span aria-hidden="true" class="glyphicon glyphicon-fast-backward"></span></a></li>
							<li
								<?php
									if($page==1){
										echo "class=\"disabled\"";
									}
								?>
							><a href="?p=<?php echo $page-1; ?>"><span aria-hidden="true" class="glyphicon glyphicon-step-backward"></span></a></li>
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
										><a href="/?p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
									><a href="/?p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
							><a href="?p=<?php echo $page+1; ?>"><span aria-hidden="true" class="glyphicon glyphicon-step-forward"></span></a></li>
							<li
								<?php
									if($page==$page_count){
										echo "class=\"disabled\"";
									}
								?>
							><a href="?p=<?php echo $page_count; ?>"><span aria-hidden="true" class="glyphicon glyphicon-fast-forward"></span></a></li>
						</ul>
					</nav>
				</section>

				<a class="btn" id="toTop"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></a>

			<?php
			}else{
			?>

				<h3>Page not found</h3>
				return to <a href="/">home page</a> or <a id="goBack">previous page</a>

			<?php
			}
			?>			

			</div><!-- container -->

		<?php include_once "assets/components/php/scripts-tag.php"; ?>
	</body>
	<?php require_once "assets/components/php/sql-disconnect.php"; ?>
</html>