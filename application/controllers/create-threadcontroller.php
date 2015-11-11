<?php
require_once (".." .  DS . "application" . DS . "models" . DS . "threadmodel.php" );

$controller = new ThreadController();

if(isset($_POST['addThread'])){
		if(isset($_POST['topic_category']) && isset($_POST['content'])){
			$firstName = retrieveUsername();
			$email = retrieveUserEmail();
			$category = $_POST['topic_category'];
			$content = $_POST['content'];

			if(isset($_POST['photo'])){
				$photo = $_POST['photo'];
				$controller->addThread($firstName, $photo, $email, $content, $category);
			}
			
			else{
				$controller->addThreadNoPhoto($firstName, $email, $content, $category);
			}

			

		}
		else{
			echo 'Please fill up the required filled';
		}
		
	}

else{
		echo 'Please Submit';
}

class ThreadController{

	private $threadmodel;

	function __construct(){
		$this->threadmodel = new ThreadModel();
	}

	function __destruct(){
	}

	function addThread($name, $photo, $user_email, $content, $category){
		$success = $this->threadmodel->addThread($name, $photo, $user_email, $content, $category);
		echo $success;
		if($success === true){
			header("Location: create-thread.php");
		}
		else{
			header("");
		}

	}

	function addThreadNoPhoto($name, $user_email, $content, $category){
		$success = $this->threadmodel->addThreadNoPhoto($name, $user_email, $content, $category);
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