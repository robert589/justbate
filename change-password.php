<?php
	require_once __DIR__.'/php/user.php';

	$message = '';

	if(isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['email'])){
		$email = $_POST['email'];
		$old_password=  $_POST['old_password'];
		$new_password = $_POST['new_password'];
		$user = new User();
		$result = $user->changePassword($email, $old_password, $new_password);
		if($result === true){
			header("location: /startUp/create-thread.html");

		}
		else{
			$message = $result;
		}

	}
?>

<html>
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
	</head>
	<body>
		<div class="full">
		<div class="col-md-offset-4 col-md-4">
			<div align="center">
				<h1>Change Password </h1>
				<?php
				echo '<h2>' . $message  . '</h2>';
				?>
			</div>

			<form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
				<div class="form-group">
					<label>Email</label>
					<input type="text" placeholder="Email" class="form-control" name="email">
				</div>
				<div class="form-group">
					<label>Old Password/Temporary Password</label>
					<input type="password" placeholder="Old Password" class="form-control" name="old_password">
				</div>
				<div class="form-group">
					<label>New Password</label>
					<input type="password" placeholder="New Password" class="form-control" name="new_password">
				</div>

				<div class="form-group">
					<label>Confirm Password</label>
					<input type="password" placeholder="Confirm Password" class="form-control" name="confirm_password">
				</div>


				<div align="center">

					<input type="submit" value="Send me an email" class="btn btn-info spacer12">

				</div>

				
			</form>	
		</div>
	</div>
	</body>
</html>