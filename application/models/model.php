	<?php
	require_once "/DomainObject/domainobjectfactory.php";
	require_once "/DataMapper/datamapperfactory.php";
	
	class Model{

		protected $domainObject;

		protected $dataMapper;

		protected $mapperfactory;


		function __construct(){
			$this->domainObject = new DomainObjectFactory();
			$this->dataMapper = new DataMapperFactory();
		}

		function __destruct(){
			
		}

		function setEmailSession($email){
			echo  '<script> console.log("hello")</script>';
			$_SESSION['email'] = $email;
		}

		function setFirstNameSession($name){
			$_SESSION['first_name'] = $name;
		}

		function setLastNameSession($name){
			$_SESSION['last_name'] = $name;
		}

		function setUserSession($user){
			$_SESSION['email'] = $user->getEmail();
			$_SESSION['first_name'] = $user->getFirstName();
			$_SESSION['last_name'] = $use->getLastName();
		}
	}