<?php require_once "../assets/components/php/questions-process.php" ; ?>

<!Doctype html>
<html>
	<head>
		<?php include_once "../assets/components/php/head-tag.php" ;?>
		<title>
		<?php
		if($title_present) 
			echo $ans['title']; 
		else
			echo "Page not found";
		?>
		</title>
	</head>
	<body>
		<?php include_once "../assets/components/php/snippet-header.php"; ?>


		<section class="container">
		

				<?php
				if($title_present){
				?>
					<h3><?php echo $ans['title']; ?></h3>
					<br>

					<section  class="panel panel-default ques-panel"><!-- question part -->

						<div class="panel-body">

							<div class="col-sm-1 votes pull-left"><!-- votes part -->
								<p class="text-center">
									<button type="button" id="ques_up" class="btn btn-warning" title="It's helpfull"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span></button>
										<?php 
											$ques_update=false;
											if(isset($_SESSION['user_name'],$_SESSION['user_id'])){
												$ques_update=true;
											}
										?>
									<span id="ques_part" data-qid="<?php echo $ans['qid']; ?>" data-update="<?php echo $ques_update; ?>"><?php echo $ans['rank']; ?></span>
									<button type="button" id="ques_down" class="btn btn-danger" title="It's not helpfull"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span></button>
								</p>
							</div><!-- votes part -->

							<div class="clearfix"><!-- content part -->
								<div class="col-xs-12 col-sm-10">
									<?php echo $ans['content']; ?>
								</div>
							</div><!-- content part -->
							
							<div class="pull-right small"><!-- user info part -->
								<?php 
									$usel="SELECT uname FROM users WHERE uid={$ans['uid']}";
									if(!$res=mysqli_query($sqlhandle,$usel)){
										mysqli_error($sqlhandle);
									}
									$name=mysqli_fetch_assoc($res);
									if($name){
										echo $name['uname']."<br>";
									}
									echo "asked ".diff_time_format($ans['utctime'],$ans['asked']);
									mysqli_free_result($res);
									$get_answers="SELECT count(*) FROM answers WHERE qid={$ans['qid']}";
									$get_ans=0;
									if(!($search=mysqli_query($sqlhandle, $get_answers))){
										echo mysqli_error($sqlhandle);
									}else{
										$g_ans=mysqli_fetch_assoc($search);
										mysqli_free_result($search);
										$get_ans=$g_ans['count(*)'];
									}
								?>
							</div><!-- user info part -->

						</div><!-- panel-body -->

					</section><!-- panel -->
						<h4><?php echo $get_ans; ?> Answers</h4>
					<div class="hrow"></div><!-- question part -->
					

					<section><!-- answers part -->
					<?php
						$query="SELECT uid,content,answered,rank,utc_timestamp() AS utctime FROM answers WHERE qid={$ans['qid']} ORDER BY rank desc,answered desc";
						if(!$result=mysqli_query($sqlhandle,$query)){
							mysqli_error($sqlhandle);
						}
						while($row=mysqli_fetch_assoc($result)){
					?>
							<section class="panel panel-default ans-panel">
								<div class="panel-body">

									<div class="col-sm-1 votes pull-left"><!-- votes part -->
										<p class="text-center">
											<button type="button" class="btn btn-warning ans_up" title="It's helpfull"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span></button>
												<?php 
													$ans_update=false;
													if(isset($_SESSION['user_name'])){
														$ans_update=true;
													}
												?>
											<span class="ans_part" data-qid="<?php echo $ans['qid']; ?>" data-uid="<?php echo $row['uid']; ?>" data-answered="<?php echo $row['answered']; ?>" data-update="<?php echo $ans_update; ?>"><?php echo $row['rank']; ?></span>
											<button type="button" class="btn btn-danger ans_down" title="It's not helpfull"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true" ></span></button>
										</p>
									</div><!-- votes part -->

									<div class="clearfix"><!-- content part -->
										<div class="col-xs-12 col-sm-10">
										<?php echo $row['content']; ?>
										</div>
									</div><!-- content part -->
									
									<br>
									<div class="pull-right small"><!-- user info part -->
									<?php
										$usel="SELECT uname FROM users WHERE uid={$row['uid']}";
										if(!$res=mysqli_query($sqlhandle,$usel)){
											mysqli_error($sqlhandle);
										}
										$name=mysqli_fetch_assoc($res);
										if($name){
											echo $name['uname']."<br>";
										}
										echo "answered ".diff_time_format($row['utctime'],$row['answered']);
									?>
									</div><!-- user info part -->

								</div><!-- panel-body -->
							</section><!-- panel -->
					<?php
						}
						mysqli_free_result($result);
					?>
						<div class="hrow"></div>
					</section><!-- answers part -->


					<section class="col-sm-11"><!-- submit part -->

						<?php
							if(isset($_SESSION['user_name'],$_SESSION['user_id'])){
						?>
								<form class="form" action="/questions/?qid=<?php echo $qid; ?>" method="post" role="form">

									<div class="form-group">
										<label class="control-label">Answer this question</label><br><br>
										<div>
											<textarea class="form-control" id="rich-text" rows="8" name="content"></textarea>
										</div>
									</div>
																
									<input type="hidden" value="<?php echo $ans['qid'] ?>" name="qid"><br>
									<input type="hidden" value="<?php echo $_SESSION['user_id'] ?>" name="uid"><br>
									<input type="submit" id="submit" value="Submit" name="submit" class="btn btn-danger col-sm-offset-">

								</form>
						<?php
							}else{
						?>
								<p class="col-sm-offset-1">
									To answer this question you must be logged in.<br><br>
									<a href="/login/?qid=<?php echo $qid; ?>">Login</a> or <a href="/register/">Register</a>
								</p>
						<?php
							}
						?>
						
					</section><!-- submit part -->

				<?php
				}else{
				?>
					<h3>Page not found</h3>
					<a href="/">return to home page</a>
				<?php
				}
				?>			

		</section><!-- container -->

		<section class="modal fade" aria-hidden="true" role="dialog" id="no_perm_ques">
			<div class="modal-dialog">
			<div class="modal-content">
					
					<div class="modal-body">
						<button type="button" class="close clearfix" data-dismiss="modal" aria-lable="close"><span aria-hidden="true">&times;</span></button><br>
						<p class="text-center clearfix">
							To vote for this question you must be logged in.<br><br>
							<a href="/login/?qid=<?php echo $qid; ?>">Login</a> or <a href="/register/">Register</a>
							<br><br><button type="button" class="btn btn-default pull-right" data-dismiss="modal">close</button>
						</p>
					</div>
					
				</div>
			</div>
		</section>


		<section class="modal fade" aria-hidden="true" role="dialog" id="no_perm_ans">
			<div class="modal-dialog">
			<div class="modal-content">
					
					<div class="modal-body">
						<button type="button" class="close clearfix" data-dismiss="modal" aria-lable="close"><span aria-hidden="true">&times;</span></button><br>
						<p class="text-center clearfix">
							To vote for this answer you must be logged in.<br><br>
							<a href="/login/?qid=<?php echo $qid; ?>">Login</a> or <a href="/register/">Register</a>
							<br><br><button type="button" class="btn btn-default pull-right" data-dismiss="modal">close</button>
						</p>
					</div>
					
				</div>
			</div>
		</section>

	<?php require_once "../assets/components/php/ckeditor-tag.php"; ?>
	<?php include_once "../assets/components/php/scripts-tag.php" ;?>
	<script src="../assets/js/questions.js"></script>
	</body>
	<?php require_once "../assets/components/php/sql-disconnect.php"; ?>
</html>