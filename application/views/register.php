<?php
	
	require_once(ROOT . DS. "application" . DS . "views" . DS . "components" .DS.  "header" . DS . "header.class.php");
	require_once(ROOT . DS. "application" . DS . "views" . DS . "components". DS . "footer" .  DS . "footer.class.php");
	require_once(ROOT . DS. "application" . DS . "views" . DS . "components". DS . "navbar" .  DS . "navbar.class.php");


	$header = new Header();
	$header->add(Header::GENERAL);
?>

	<nav class="navbar navbar-default" id="navBar">
			<?php $navbar = new NavBar();
			$navbar->add(NavBar::BEFORE_LOGIN);?>
	</nav>



	<div class="full">
		<div class="col-xs-12">
			<!--Side Bar-->
			<div class="col-xs-3" id="navSide">
			</div>

			<div class="col-xs-6" >

				<h1>Register Page</h1>
				<form role="form" id="signUpForm" action="registercontroller.php" method="post">
					<div class="form-group">
						<div class="form-inline spacer-12">
							<input type="text" class="form-control"  name="userFirstName" placeholder="First Name">
							<input type="text" class="form-control"  name="userLastName" placeholder="Last Name">

						</div>	
					</div>

					<div class="form-group ">	
					
						<input type="text" class="form-control"
						name="userEmail"
						placeholder="Email">
					</div>

					<div class="form-group ">
						<input type="password" class="form-control" name="userPassword" placeholder="Password">
					</div>

					<div class="form-group ">
						<input type="password" class="form-control" name="confirmPassword" placeholder="Password">
					</div>

					<div class="form-group ">
						  <label> Birthday* </label>
						  <input type="date" class="form-control" name="userBirthday" placeholder="Birthday">

					</div>
					<input type="submit" name="register" class="btn btn-info spacer-12" style="clear:both" >


				</form>
				


			</div>
		</div>
	</div>