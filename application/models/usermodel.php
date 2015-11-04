<?php
	require_once 'model.php';


	class UserModel extends Model{
		
		private $user; 


		function __construct(){
			parent::__construct();
			$this->mapperfactory = $this->dataMapper->getDataMapper(DataMapperFactory::USER_MAPPER);
		}

		function __destruct(){

		}

		function login($email, $password){
			$this->mapperfactory = $this->dataMapper->getDataMapper(DataMapperFactory::USER_MAPPER);

			$user = $this->domainObject->getDomainObject(DomainObjectFactory::USER_ENTITY);


			//store data to domain object
			$user->setEmail($email);
			$user->setPassword($password);

			//pass it to mapper
			if($this->mapperfactory->login($user)){

				$this->updateSession($email);	
				return true;
			}
			else{
				return false;
			}
		}

		function register($firstName, $lastName, $email, $password, $birthdate){
			$this->mapperfactory = $this->dataMapper->getDataMapper(DataMapperFactory::USER_MAPPER);

			$user = $this->domainObject->getDomainObject(DomainObjectFactory::USER_ENTITY);

			$user->setFirstName($firstName);
			$user->setLastName($lastName);
			$user->setEmail($email);
			$user->setPassword($password);
			$user->setBirthdate($birthdate);

			if($this->mapperfactory->register($user)){				
				$this->updateSession($email);
				return true;
			}
			else{
				return false;
			}
		}

		function verifyCode($code){
			$this->mapperfactory = $this->dataMapper->getDataMapper(DataMapperFactory::USER_MAPPER);

			$this->mapperfactory->verifyCode($code);
		}
		
		private function updateSession($email){
			$this->mapperfactory = $this->dataMapper->getDataMapper(DataMapperFactory::USER_MAPPER);

			session_start();
			$received_user = $this->mapperfactory->retrieveUser($email);
			$this->setFirstNameSession($received_user['first_name']);
			$this->setLastNameSession($received_user['last_name']);

			$this->setEmailSession($received_user['email']);



		}
	}