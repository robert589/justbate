<?php
	require_once __DIR__.'/php/user.php';	

	if(isset($_POST["userFirstName"]) && isset($_POST["userEmail"]) && isset($_POST["userPassword"])  && isset($_POST["userBirthday"])){
		$userFirstName = $_POST["userFirstName"];
		$userEmail  = $_POST["userEmail"];
		$userPassword = $_POST["userPassword"];
		$userBirthday = $_POST["userBirthday"];


		//echo "<script type='text/javascript'>alert('dsds');</script>";
		$regUser = new User();

		$valid = false;

		if(isset($_POST['userLastName'])){
			$userLastName = $_POST['userLastName'];
			$valid = $regUser->signUp($userEmail, $userFirstName, $userLastName, $userPassword, $userBirthday);

	    }
		else{
			$valid = $regUser->signUp($userEmail, $userFirstName, $userLastName, $userPassword, $userBirthday);
		}

		if($valid === true){
			header("location: /startUp/create-thread.html");
		}
		else{
		}
	}
	
?>


<html lang="en">
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<link rel="stylesheet" href="css/manual.css">
	<!-- Optional theme -->

	<!-- Latest compiled and minified JavaScript -->
	<script src="http://code.jquery.com/jquery-latest.min.js"
        type="text/javascript"></script>


	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>

	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
	<title>Register</title>
</head>

<body>

	<nav class="navbar navbar-default" id="navBar">
		
	</nav>

	<div class="full">
		<div class="col-xs-12">
			<!--Side Bar-->
			<div class="col-xs-3" id="navSide">
			</div>

			<div class="col-xs-6" >

				<h1>Register Page</h1>
				<form role="form" id="signUpForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
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
					<input type="submit" class="btn btn-info spacer-12" style="clear:both" >


				</form>
				


			</div>
		</div>
	</div>


	<script src="js/startup.js"></script>
	<script src="js/signup.js"></script>

</body>
</html>

<?php?>