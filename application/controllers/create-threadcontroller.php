<?php
require_once (".." .  DS . "application" . DS . "models" . DS . "threadmodel.php" );

$controller = new ThreadController();

class ThreadController{
	function __construct(){
		$this->threadmodel = new ThreadModel();
	}

	function __destruct(){
	}

	function addThread($name, $photo, $user_email){
		$success = $this->threadmodel->addThread($name, $photo, $user_email);
		echo $success;
		if($success === true){
			header("Location: create-thread.php");
		}
		else{
			header("");
		}

	}

	function addThreadNoPhoto($name, $user_email){
		$success = $this->threadmodel->addThread($name, $user_email);
		echo $success;
		if($success === true){
			header("Location: create-thread.php");
		}
		else{
			header("");
		}

	}

	function deleteThread(){

	}
}