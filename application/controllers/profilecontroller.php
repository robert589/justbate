<?php
	require_once (".." .  DS . "application" . DS . "models" . DS . "usermodel.php" );

	class ProfileController{
		private $usermodel;

		function __construct(){
			$this->usermodel = new UserModel();
		}

		function __destruct(){

		}

		function retrieveUser($username){
			return $this->usermodel->retrieveUser($username);
			
		}
	}