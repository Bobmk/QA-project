<?php require_once "../assets/components/php/process-ask.php"; ?>
<!Doctype html>
<html>
	<head>
	<title>Ask a Question</title>
	<?php require_once "../assets/components/php/head-tag.php"; ?>
	</head>
	<body>
	<?php require_once "../assets/components/php/snippet-header.php"; ?>

	<div class="container">

		<div>
			
			<?php
			if(isset($_SESSION['user_name'])){
			?>
			<form class="form-horizontal" action="/ask/" method="post" role="form">

				<div class="form-group">
					<label id="title" class="control-label col-sm-1">Title</label>
					<div class="col-sm-11">
						<input type="text" class="form-control" name="title">
					</div>
				</div><br><br>

				<div class="form-group">
					<label class="control-label col-sm-1">Content</label>
					<div class="col-sm-11">
						<textarea class="form-control" id="rich-text" rows="8" name="content"></textarea>
					</div>
				</div>


				<br><br>
					
					<input type="hidden" value="<?php echo $_SESSION['user_id'] ?>" name="uid">
					<input type="submit" id="submit" value="Submit" name="submit" class="btn btn-warning col-sm-offset-1">	
				
			</form>
			<?php
			}else{
			?>
				<br><br>
				<p class="col-sm-offset-1">
					To ask a question you must be logged in.<br><br>
					<a href="/login/">Login</a> or <a href="/register/">Register</a>
				</p>
			<?php
			}
			?>

		</div><!-- row -->

	</div><!-- container -->
	<?php require_once "../assets/components/php/ckeditor-tag.php"; ?>
	<?php require_once "../assets/components/php/scripts-tag.php"; ?>
	<script src="/assets/js/ask.js"></script>
	</body>
	<?php require_once "../assets/components/php/sql-disconnect.php"; ?>
</html>