<?php
	require_once 'model.php';


	class ThreadModel extends Model{
		
		private $user; 

		private $mapper;
		function __construct(){
			parent::__construct();
			$this->mapper = $this->dataMapper->getDataMapper(DataMapperFactory::THREAD_MAPPER);
		}

		function __destruct(){

		}

		function retrieveNewestPage($index){		

			$result = $this->mapper->retrieveNewestThread($index);
			$row = $result->num_rows;

			
			$resultThread = array();
			for($i = 0; $i < $row; $i++){
				$thread  = new Thread();
				$thread_result = mysqli_fetch_array($result);

			//	$thread->setID($thread_result['thread_id']);
				$thread->setName($thread_result['name']);
				$thread->setDateCreated($thread_result['date_created']);
				if(isset($thread_result['photo'])){
					$thread->setPhoto($thread_result['photo']);
				}
				$thread->setUserEmail($thread_result['user_email']);


				//Push it to array
				array_push($resultThread, $thread);
			}

			return $resultThread;
		}

		function addThread($name, $photo, $user_email){
			

			$newThread = $this->domainObject->getDomainObject(DomainObjectFactory::THREAD_ENTITY);


			$newThread->setName($name);
			$newThread->setPhoto($photo);
			$newThread->setEmail($email);
			

			if($this->mapper->addThread($newThread)){				
				$this->updateSession($email);
				return true;
			}
			else{
				return false;
			}

	}

		function addThreadNoPhoto($name, $email){
			$newThread = $this->domainObject->getDomainObject(DomainObjectFactory::THREAD_ENTITY);


			$newThread->setName($name);
			
			$newThread->setEmail($email);
			

			if($this->mapper->addThread($newThread)){				
				$this->updateSession($email);
				return true;
			}
			else{
				return false;
			}

		}


	}