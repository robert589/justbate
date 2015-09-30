<?php


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
			<h1>Forgot Password </h1>
		</div>

			<form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
				<div class="form-group">
					<input type="text" placeholder="email" class="form-control" name="email">
				</div>

				<div align="center">
					<input type="submit" value="Send me an email" class="btn btn-info spacer12">
						
				</div>

				
			</form>	
		</div>
	</div>
	</body>

</html>