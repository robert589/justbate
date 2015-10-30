<?php
	require_once 'model.php';


	class UserModel extends Model{
		
		private $user; 

		private $mapper;

		function __construct(){
			parent::__construct();
			$this->mapper = $this->dataMapper->getDataMapper(DataMapperFactory::USER_MAPPER);
		}

		function __destruct(){

		}

		function login($email, $password){

			$user = $this->domainObject->getDomainObject(DomainObjectFactory::USER_ENTITY);


			//store data to domain object
			$user->setEmail($email);
			$user->setPassword($password);

			//pass it to mapper
			if($this->mapper->login($user)){

				$this->updateSession($email);	
				return true;
			}
			else{
				return false;
			}
		}

		function register($firstName, $lastName, $email, $password, $birthdate){

			$user = $this->domainObject->getDomainObject(DomainObjectFactory::USER_ENTITY);

			$user->setFirstName($firstName);
			$user->setLastName($lastName);
			$user->setEmail($email);
			$user->setPassword($password);
			$user->setBirthdate($birthdate);

			if($this->mapper->register($user)){				
				$this->updateSession($email);
				return true;
			}
			else{
				return false;
			}
		}

		function verifyCode($code){
			$this->mapper->verifyCode($code);
		}
		
		private function updateSession($email){
			session_start();
			$received_user = $this->mapper->retrieveUser($email);
			$this->setFirstNameSession($received_user['first_name']);
			$this->setLastNameSession($received_user['last_name']);

			$this->setEmailSession($received_user['email']);



		}
	}