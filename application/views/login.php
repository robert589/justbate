<?php	

	//include controller
	require_once(ROOT . '/application/models/usermodel.php');
	require_once(ROOT . '/application/controllers/logincontroller.php')	;

	addHeader(Header::GENERAL);
?>


	<nav class="navbar navbar-default" id="navBar">
		<?php addNavbar(Navbar::BEFORE_LOGIN)?>
	</nav>

	<div class="full">
		<div class="col-md-offset-4 col-md-4">
			<div align="center">
			<h1>Login </h1>
		</div>


			<form role="form" action="logincontroller.php" method="post">
				<div class="form-group">
					<input type="text" placeholder="email" class="form-control" name="email">
				</div>

				<div class="form-group">
					<input type="password" placeholder="password" class="form-control" name="password">
				</div>

				<div align="center">
					<input type="submit" value="Submit" name="login" class="btn btn-info spacer12">
				</div>

				<div align="center">									
					<a href="/startUp/forgot-password.php">Forgot password</a>
				</div>
			</form>	
		</div>
	</div>