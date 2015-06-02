<?php 
session_start();
	$target=false;
	if(isset($_GET['qid'])){
		$_SESSION['get_qid']=$_GET['qid'];
	}
	if(isset($_SESSION['get_qid'])){
		$target=true;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login - Q &amp; A</title>
		<?php require_once "../assets/components/php/head-tag.php"; ?>
	</head>

	<body>
		<?php require_once "../assets/components/php/snippet-header.php"; ?>

		<div class="container">

			<div>
				<p class="h2 text-center">Login</p><br><br>

				<?php 
				if(isset($_SESSION['errmsg'])){
					$msg=$_SESSION['errmsg'];
					$_SESSION['errmsg']=null;
				?>
					<section class="clearfix">
						<div class="alert alert-danger alert-dismissible col-sm-5 col-sm-offset-3" role="alert" id="msg">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo $msg; ?>
						</div>
					</section>
				<?php
				}
				?>
				<section>

					<form class="form-horizontal col-sm-offset-2" action="/assets/components/php/process-login.php" id="log_form" method="post" role="form">
					

						<div class="form-group">
							<label class="control-label col-sm-3">Email</label>
							<div class="col-sm-6 col-md-5">
								<input class="form-control" type="text" name="login" id="login" placeholder="Email">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3">Password</label>
							<div class="col-sm-6 col-md-5">
								<input class="form-control" type="password" name="password" id="password" placeholder="Password">
							</div>
						</div>
						<?php
							if($target){
						?>
							<input type="hidden" name="qid" value="<?php echo $_SESSION['get_qid']; ?>" id="qid">
						<?php 
							} 
						?>

						<br>
						<button type="submit" id="submit" value="Submit" name="submit" class="col-sm-offset-3 col-xs-12 col-sm-6 col-md-5 btn btn-primary disabled">Login</button>

					</form>
				</section>

			</div>

		</div><!-- container -->

	<?php require_once "../assets/components/php/scripts-tag.php"; ?>
	<script src="/assets/js/login.js"></script>
	</body>
</html>