<?php
	$message = "";
	require_once __DIR__.'/php/user.php';
	if(isset($_GET['code'])){
		$code = $_GET['code'];

		$user = new User();
		$result  = $user->updateValidation($code);
		if($result === true){
			$message = "Your account has been succesfully validated";
		}
		else{
			$message = $result;
		}
	}


	
?>

<html>
		<head>
		</head>
		<body>
			<div class="full">
				<div class="col-md-4 col-md-offset-4">
					<div align="center">
						<?php
						echo '<h2>' . $message  . '</h2>';
						?>
					</div>
				</div>
			</div>
		</body>
</html>
