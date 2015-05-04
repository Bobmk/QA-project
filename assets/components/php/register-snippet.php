<div>
	<p class="h2 text-center">Register</p><br><br>

		<?php 
		if(isset($_SESSION['errmsg'])){
			$msg=$_SESSION['errmsg'];
			unset($_SESSION['errmsg']);
		?>
		<section class="clearfix">
			<div class="alert alert-danger alert-dismissible col-sm-5 col-sm-offset-2" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo $msg; ?>
			</div>
		</section>
		<?php
		}
		?>

		<section>
			
			<form id="reg_form" class="form-horizontal col-sm-offset-2" action="/assets/components/php/process-register.php" method="post" role="form">

				<div class="form-group">
					<label class="control-label col-sm-3">Name</label>
					<div class="col-sm-6 col-md-5 col-lg-4">
						<input class="form-control" type="text" name="username" id="name" placeholder="name (for display)">
						<span class="text-danger hidden" id="name_emp">this field cannot be empty</span>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Email ID</label>
					<div class="col-sm-6 col-md-5 col-lg-4">
						<input class="form-control" id="login_id" type="email" name="email" placeholder="email id (not shown)">
						<span class="text-danger hidden clearfix" id="em_pat">enter valid email id</span>
						<span class="text-danger hidden" id="email_emp">this field cannot be empty</span>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Enter Password</label>
					<div class="col-sm-6 col-md-5 col-lg-4">
						<input class="form-control" data-placement="bottom" data-toggle="tooltip" title="8-20 characters, must contain uppercase, lowercase, digit and symbol" type="password" id="pass1" placeholder="enter password">
						<span class="text-danger hidden clearfix" id="pass_pat">match the pattern</span>
						<span class="text-danger hidden" id="pass1_emp">this field cannot be empty</span>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Confirm Password</label>
					<div class="col-sm-6 col-md-5 col-lg-4">
						<input class="form-control" type="password" id="pass2" name="password" placeholder="confirm password">
						<span class="text-danger hidden clearfix" id="pass_danger">passwords do not match</span>
						<span class="text-danger hidden" id="pass2_emp">this field cannot be empty</span>
					</div>
				</div>
				<!-- <div class="form-group">
				<label class="control-label col-sm-2">Gender</label>
						<label class="radio col-sm-2 col-sm-offset-1">
							Male <input type="radio" name="gender" value="male">
						</label>
						<label class="radio col-sm-2">
							Female <input type="radio" name="gender" value="female">
						</label>
				</div> -->
				
				<!-- <div class="form-group">
					<label for="membership" class="col-sm-2 control-label">Membership</label>
					<div class="col-xs-10 col-sm-6 col-md-5 col-lg-4">
						<select name="membership" class="form-control" id="member" data-toggle="popover" data-trigger="focus" data-content="this field cannot be empty">
							<option value="null" checked>-------</option>
							<option value="student">Student</option>
							<option value="teacher">Teacher</option>
						</select>
					</div>
				</div> -->

				<br>
				<button type="submit" id="submit" value="Submit" name="submit" class="col-xs-offset-4 col-sm-offset-3 btn btn-default">Submit</button>

			</form>

		</section>

</div>