<?php
	
	require_once('/logincontroller.php');

	$controller = new NavbarController();

	if(isset($_GET['action'])){
		$action = $_GET['action'];
		if(strcmp($action , 'logout') === 0){
			$controller->logout();
		}

	}
	
	if(isset($_POST['login'])){
		if(isset($_POST['email']) && isset($_POST['password'])){
			$email = $_POST['email'];
			$password = $_POST['password'];
			$controller->login($email, $password);
		}
	}

	class NavbarController{

		//This is rule violation, controller cannot communicate with other controllers
		//have to be discussed
		private $logincontroller;


		function __construct(){
			$this->logincontroller = new LoginController();
		}

		function __destruct(){

		}

		function logout(){

			// Initialize the session.
			// If you are using session_name("something"), don't forget it now!
			session_start();

			// Unset all of the session variables.
			$_SESSION = array();

			// If it's desired to kill the session, also delete the session cookie.
			// Note: This will destroy the session, and not just the session data!
			if (ini_get("session.use_cookies")) {
    			$params = session_get_cookie_params();
    			setcookie(session_name(), '', time() - 42000,
        		$params["path"], $params["domain"],
        		$params["secure"], $params["httponly"]
    			);
			}

		// Finally, destroy the session.
		session_destroy();

		header('location: home.php');

		}

		function login($email, $password){
			$result = $this->logincontroller->login($email, $password);

			if($result == true){
				header('location: home.php');

			}
		}
	}