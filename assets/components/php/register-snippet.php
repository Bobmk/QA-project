<div>
	<p class="h2 text-center">Register</p><br><br>

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

		<section>
			
			<form id="reg_form" class="form-horizontal col-sm-offset-2" action="/assets/components/php/process-register.php" method="post" role="form">

				<div class="form-group has-feedback">
					<label class="control-label col-sm-3">Username</label>
					<div class="col-sm-6 col-md-5">
						<input class="form-control" type="text" name="username" id="name" placeholder="Username (for display)" autocomplete="off">
						<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						<span class="text-danger hidden" id="name_emp">this field cannot be empty</span>
						<span class="text-danger hidden" id="not_uniq">username not available</span>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Email</label>
					<div class="col-sm-6 col-md-5">
						<input class="form-control" id="login_id" type="email" name="email" placeholder="Email (not shown)">
						<span class="text-danger hidden clearfix" id="em_pat">enter valid email id</span>
						<span class="text-danger hidden" id="email_emp">this field cannot be empty</span>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Enter Password</label>
					<div class="col-sm-6 col-md-5">
						<input class="form-control" data-placement="bottom" data-toggle="tooltip" title="8-20 characters, must contain uppercase, lowercase, digit and symbol" type="password" id="pass1" placeholder="Enter password">
						<span class="text-danger hidden clearfix" id="pass_pat">match the pattern</span>
						<span class="text-danger hidden" id="pass1_emp">this field cannot be empty</span>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Confirm Password</label>
					<div class="col-sm-6 col-md-5">
						<input class="form-control" type="password" id="pass2" name="password" placeholder="Confirm password">
						<span class="text-danger hidden clearfix" id="pass_danger">passwords do not match</span>
						<span class="text-danger hidden" id="pass2_emp">this field cannot be empty</span>
					</div>
				</div>

				<br>
				<button type="reset" id="reset" class="col-sm-offset-3 col-xs-12 col-sm-6 col-md-5 btn btn-warning">Reset</button><br><br>
				<button type="submit" id="submit" value="Submit" name="submit" class="col-sm-offset-3 col-xs-12 col-sm-6 col-md-5 btn btn-primary disabled">Submit</button>

			</form>

		</section>

</div>