<?php
//echo 'hello';
if(isset($_POST['email']) && isset($_POST['password'])){
	$email  = $_POST['email'];
	$password = $_POST['password'];
//tes

	require_once __DIR__.'/php/user.php';	

		//echo "<script type='text/javascript'>alert('dsds');</script>";
	$logUser = new User();

	$valid = $logUser->login($email, $password);

	if($valid){
			//START THE SESSION
		session_start();
		$result = $logUser->retrieveUserData($email);

		$_SESSION['email'] = $result['email'];
		$_SESSION['first_name'] = $result['first_name'];
		$_SESSION['last_name'] = $result['last_name'];
		//$SESSION['password'] = $result['email'];
		//$SESSION['email'] = $result['email'];


		header("location: /startUp/create-thread.html");
		exit();
	}
	else{

	}

}
?>

<html lang='en'>
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
	<title>Login</title>
</head>
<body>



	<div class="full">
		<div class="col-md-offset-4 col-md-4">
			<div align="center">
			<h1>Login </h1>
		</div>

			<form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
				<div class="form-group">
					<input type="text" placeholder="email" class="form-control" name="email">
				</div>

				<div class="form-group">
					<input type="password" placeholder="password" class="form-control" name="password">
				</div>

				<div align="center">
					<input type="submit" value="Submit" class="btn btn-info spacer12">
				</div>

				<div align="center">									
					<a href="/startUp/forgot-password.php">Forgot password</a>
				</div>
			</form>	
		</div>
	</div>
	
</body>
</html>