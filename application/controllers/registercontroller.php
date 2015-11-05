<?php
	require_once (".." .  DS . "application" . DS . "models" . DS . "usermodel.php" );

	$controller = new RegisterController();

	if(isset($_POST['register'])){
		if(isset($_POST['userFirstName']) && isset($_POST['userLastName']) && isset($_POST['userEmail']) && isset($_POST['userPassword']) 
			&& isset($_POST['userBirthday']) && isset($_POST['username'])){
			$firstName = $_POST['userFirstName'];
			$lastName = $_POST['userLastName'];
			$email = $_POST['userEmail'];
			$password = $_POST['userPassword'];
			$birthdate = $_POST['userBirthday'];
			$username = $_POST['username'];

			$controller->register($firstName, $lastName, $email, $password, $birthdate,$username);

		}
		else{
			echo 'it is inside';
		}
		
	}
	else if(isset($_GET['code'])){
			$code = $_GET['code'];
			$controller->checkVerification($code);
	}
	else{
		echo 'Command Not Found';
	}

class RegisterController{

	private $usermodel;

	function __construct(){
		$this->usermodel = new UserModel();
	}

	function __destruct(){

	}

	function register($firstName, $lastName, $email, $password, $birthdate, $username){
		$success = $this->usermodel->register($firstName, $lastName, $email, $password, $birthdate, $username);
		//echo $success;
		if($success === true){
			header("Location: home.php");
		}
		else{
			header("");
		}
	}

	function checkVerification($code){
		$this->usermodel->verifyCode($code);
	}
	
}