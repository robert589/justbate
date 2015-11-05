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

		function retrieveUser($username){
			$usermapper = $this->dataMapper->getDataMapper(DataMapperFactory::USER_MAPPER);

			$user_db_result = $usermapper->retrieveUser($username);

			$user = $this->domainObject->getDomainObject(DomainObjectFactory::USER_ENTITY);

			$user->setEmail($user_db_result['email']);
			$user->setUsername($user_db_result['username']);
			$user->setUsername($user_db_result['username']);
			$user->setFirstName($user_db_result['first_name']);
			$user->setLastName($user_db_result['last_name']);
			$user->setBirthdate($user_db_result['birthday']);
			$user->setTotalLike($user_db_result['total_like']);
			$user->setTotalDislike($user_db_result['total_dislike']);
			$user->setYellowCard($user_db_result['yellow_card']);


			return $user;

		}

		function retrieveUserWithEmail($email){
			$usermapper = $this->dataMapper->getDataMapper(DataMapperFactory::USER_MAPPER);

			$user_db_result = $usermapper->retrieveUserWithEmail($username);

			$user = $this->domainObject->getDomainObject(DomainObjectFactory::USER_ENTITY);

			$user->setEmail($user_db_result['email']);
			$user->setUsername($user_db_result['username']);
			$user->setUsername($user_db_result['username']);
			$user->setFirstName($user_db_result['first_name']);
			$user->setLastName($user_db_result['last_name']);
			$user->setBirthdate($user_db_result['birthday']);
			$user->setTotalLike($user_db_result['total_like']);
			$user->setTotalDislike($user_db_result['total_dislike']);
			$user->setYellowCard($user_db_result['yellow_card']);


			return $user;

		}

		function register($firstName, $lastName, $email, $password, $birthdate, $username){
			$this->mapperfactory = $this->dataMapper->getDataMapper(DataMapperFactory::USER_MAPPER);

			$user = $this->domainObject->getDomainObject(DomainObjectFactory::USER_ENTITY);

			$user->setFirstName($firstName);
			$user->setLastName($lastName);
			$user->setEmail($email);
			$user->setPassword($password);
			$user->setBirthdate($birthdate);
			$user->setUsername($username);

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

			if (session_status() == PHP_SESSION_NONE) {
    			session_start();
			}
			$received_user = $this->mapperfactory->retrieveUserWithEmail($email);
			$this->setFirstNameSession($received_user['first_name']);
			$this->setLastNameSession($received_user['last_name']);
			$this->setUsernameSession($received_user['username']);
			$this->setEmailSession($received_user['email']);



		}
	}