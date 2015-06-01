<?php
require_once "../assets/components/php/profile-snippet.php";
require_once "../assets/components/php/functions.php";
?>
<!doctype html>
<html>
	<?php require_once "../assets/components/php/head-tag.php"; ?>
	<title>Profile | <?php echo $_SESSION['user_name']; ?> - Q &amp; A</title>

	<body>
		<?php require_once "../assets/components/php/snippet-header.php"; ?>

		<div class="container">

			<!-- <section > -->
				<?php 
					$update=0;
					if(isset($_SESSION['update_success'])){
						$update=$_SESSION['update_success'];
						unset($_SESSION['update_success']);
					}
					if($update){ 
				?>
						<section class="clearfix">
							<div class="alert alert-success alert-dismissible col-sm-5 col-sm-offset-2" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>All setting successfully updated
							</div>
						</section>
				<?php } ?>

				<?php 
					if(isset($_SESSION['errmsg'])){
						$msg=$_SESSION['errmsg'];
						unset($_SESSION['errmsg']);
				?>
					<section class="clearfix">
						<div class="alert alert-danger alert-dismissible col-sm-5 col-sm-offset-3" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo $msg; ?>
						</div>
					</section>
				<?php
				}
				?>
			<!-- </section> -->

			<section>
				
				<form role="form" action="../assets/components/php/process-profile.php" method="post" class="form-horizontal col-sm-offset-2" id="prof_form">

					<fieldset>
						<legend>Personal Settings</legend>
					
						<div class="form-group has-feedback">
							<label class="control-lable col-sm-3">User Name</label>
							<div class="col-sm-6 col-md-5">
								<input type="text" class="form-control" name="nuname" id="nuname" value="<?php echo $result['uname']; ?>">
								<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
								<span class="text-danger hidden" id="name_emp">this can't be empty</span>
								<span class="text-danger hidden" id="not_uniq">username already taken</span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-lable col-sm-3">Joined</label>
							<div class="col-sm-6 col-md-5">
								<p class="form-control-static"><?php echo date_string($result['joined']); ?></p>
							</div>
						</div>

						<div class="form-group">
							<label class="control-lable col-sm-3">Questions asked</label>
							<div class="col-sm-6 col-md-5">
								<p class="form-control-static"><?php echo $result['q_asked']; ?></p>
							</div>
						</div>

						<div class="form-group">
							<label class="control-lable col-sm-3">Questions answered</label>
							<div class="col-sm-6 col-md-5">
								<p class="form-control-static"><?php echo $result['q_answered']; ?></p>
							</div>
						</div>

						<div class="form-group has-feedback">
							<label class="control-lable col-sm-3">New Password</label>
							<div class="col-sm-6 col-md-5">
								<input type="password" class="form-control" name="npass" id="npass" placeholder="enter new password" data-placement="top" data-toggle="tooltip" title="8-20 characters, must contain uppercase, lowercase, digit and symbol">
								<span class="glyphicon form-control-feedback"></span>
								<span class="text-danger hidden clearfix" id="pass_pat">match the pattern</span>
								<span class="text-danger hidden clearfix" id="pass_empty">this field should not be empty</span>
								<span class="text-danger hidden" id="pass_diff">password should be different from current one</span>
							</div>
						</div>
						<div class="form-group has-feedback">
							<label class="control-lable col-sm-3">Retype password</label>
							<div class="col-sm-6 col-md-5">
								<input type="password" class="form-control" id="rnpass" placeholder="retype new password">
								<span class="glyphicon form-control-feedback"></span>
								<span class="text-danger hidden" id="pass_match">match with new password</span>
							</div>
						</div>

						<input type="hidden" name="uid" value="<?php echo $result['uid']; ?>" id="uid">
						<input type="hidden" value="<?php echo $result['uname']; ?>" id="uname">

						<div class="form-group has-feedback">
							<label class="control-lable col-sm-3">Current Password</label>
							<div class="col-sm-6 col-md-5">
								<input type="password" class="form-control" id="cpass" placeholder="enter current password">
								<span class="glyphicon form-control-feedback"></span>
								<span class="text-danger hidden clearfix" id="pass_err">must enter current password</span>
								<span class="text-danger hidden" id="pass_wrong">wrong password</span>
							</div>
						</div>

						<br>
						<button type="submit" name="submit" value="Submit" id="submit" class="col-sm-offset-3 col-xs-12 col-sm-6 col-md-5 btn btn-primary">Update</button>

					</fieldset>
				</form>

			</section>
		</div><!-- container -->


		<section class="modal fade" aria-hidden="true" role="dialog" id="no_update">
			<div class="modal-dialog modal-sm">
			<div class="modal-content">
				
					<div class="modal-body">
						<button type="button" class="close clearfix" data-dismiss="modal" aria-lable="close"><span aria-hidden="true">&times;</span></button><br>
						<p class="text-center clearfix">nothing to update
						<br><br><button type="button" class="btn btn-default pull-right" data-dismiss="modal">close</button>
						</p>
					</div>
					
				</div>
			</div>
		</section>



		<?php require_once "../assets/components/php/scripts-tag.php"; ?>
		<script src="../assets/js/profile.js"></script>
	</body>
	<?php require_once "../assets/components/php/sql-disconnect.php"; ?>
</html>