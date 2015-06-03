<nav class="navbar navbar-inverse" role="navigation">
	<div class="container">
		
		<section class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse"
			data-target="#menu">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/">Q &amp; A</a>
		</section><!-- navbar-header -->

		<section class="collapse navbar-collapse navbar-right" id="menu">
							
			<ul class="nav navbar-nav">
				<li><a href="/" data-placement="bottom" data-toggle="tooltip" title="Home"><span class="glyphicon glyphicon-home hidden-xs" aria-hidden="true"></span><span class="visible-xs"> Home</span></a></li>
				<li><a href="/ask/" data-placement="bottom" data-toggle="tooltip" title="Ask a question"><span class="glyphicon glyphicon-question-sign hidden-xs" aria-hidden="true"></span><span class="visible-xs"> Ask a question</span></a></li>
				<?php
				if(isset($_SESSION['user_name'],$_SESSION['user_id'])){
				?>
					
					<li><a href="/users/"><span class="glyphicon glyphicon-user hidden-xs" aria-hidden="true"></span> <?php echo $_SESSION['user_name'] ; ?></a></li>
					<?php
						if(isset($_SESSION['admin']) && $_SESSION['admin']){
					?>
						<li><a href="/admins/" data-placement="bottom" data-toggle="tooltip" title="Admins"><span class="glyphicon glyphicon-star hidden-xs" aria-hidden="true"></span><span class="visible-xs"> Admins</span></a></li>
					<?php
						}
					?>
					<li><a href="/logout/" data-placement="bottom" data-toggle="tooltip" title="Log out"><span class="glyphicon glyphicon-log-out hidden-xs" aria-hidden="true"></span><span class="visible-xs"> Log out</span></a></li>

				<?php
				}else{
				?>
						<li><a href="/register/" data-placement="bottom" data-toggle="tooltip" title="Register"><span class="glyphicon glyphicon-list-alt hidden-xs" aria-hidden="true"></span><span class="visible-xs"> Register</span></a></li>
						<li><a href="/login/" data-placement="bottom" data-toggle="tooltip" title="Login"><span class="glyphicon glyphicon-log-in hidden-xs" aria-hidden="true"></span><span class="visible-xs"> Login</span></a></li>
				<?php
				}
				?>
			</ul>
					
		</section><!-- collapse -->

		<form id="search_form" class="navbar-form navbar-right" role="search" method="GET" action="/search/">
			<div class="form-group">
				<input type="search" id="term" class="form-control" name="term" placeholder="Search questions">
			</div>
		</form>
		
	</div><!-- container -->
</nav>