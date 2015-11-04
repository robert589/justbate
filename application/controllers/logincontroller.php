<?php

require_once (".." .  DS . "application" . DS . "models" . DS . "usermodel.php" );

$controller = new LoginController();

if(isset($_POST['login'])){

	if(isset($_POST['email']) && isset($_POST['password'])){
		$email = $_POST['email'];
		$password = $_POST['password'];
		$controller->login($email, $password);
	}
}

class LoginController{

	private $usermodel;
	function __construct(){
		$this->usermodel = new UserModel();
	}

	function __destruct(){
		
	}

	function login($email, $password){
		$success = $this->usermodel->login($email, $password);
		//echo $success;

		if($success === true){
			header("Location: home.php");
		}
		else{
			header("ss");
		}
	}
	
	
}