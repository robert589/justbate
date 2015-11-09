<?php

	class ThreadMapper{

		private $con;

		
		function __construct(){
			$db = new DB_CONNECT();
			$this->con = $db->connect();
		}

		function __destruct(){

		}

		function retrieveNewestThread($index){
			$sql = "SELECT name, photo, user_email, date_created, thread_id
			from thread 
			order by date_created asc
			LIMIT 1";
			$result = $this->con->query($sql) or die (mysqli_error($this->con));
			
			if($result->num_rows > 0){
				return $result;					
			}
		}

		function retrieveComment($thread_id){
			$sql = "SELECT comment_id, first_name, last_name, comment, date_created 
			from comment inner join user 
			on comment.email = user.email 
			where thread_id = $thread_id";

			$result = $this->con->query($sql) or die (mysqli_error($this->con));


			if($result->num_rows > 0){
				return $result;
			}
		}

		function insertNewThread(){
			$email = $user->getEmail();
			$password = $user->getPassword();
			$firstName = $user->getFirstName();
			$lastName = $user->getLastName();
			$birthdate = $user->getBirthdate();
			$username = $user->getUsername();
			$password = md5($password);


			$sql = "INSERT INTO user(username, first_name, email, last_name, password, birthday)
			VALUES ('$username', '$firstName', '$email', '$lastName', '$password', '$birthdate')";

			//echo $con;
			if( $this->con->query($sql)){
				
				require_once __DIR__.'\support\mailer.support.php';

				$body = $this->getVerificationBody($email);
				$mailer = new Mailer($email, $this->con, $body);
				$success = $mailer->sendMail();

				return $success;
			}
			else{
				return die("INVALID ERROR: ". mysqli_error($this->con));
			}



			//$sql = "INSERT "
		}
	}