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

		function insertNewThread($thread){
			$email = $thread->getUserEmail();
			$name = $thread->getName();
			$photo = $thread->getPhoto();
			$category = $thread->getCategory();
			$content = $thread->getContent();
			


			$sql = "INSERT INTO thread(name, photo, user_email, category, content)
			VALUES ('$name', '$photo', '$email', '$category', '$content')";

			//echo $con;
			if( $this->con->query($sql)){
				
				require_once __DIR__.'\support\mailer.support.php';

				//$body = $this->getVerificationBody($email);
				$mailer = new Mailer($email, $this->con, $body);
				$success = $mailer->sendMail();

				return $success;
			}
			else{
				return die("INVALID ERROR: ". mysqli_error($this->con));
			}



		}

		function insertNewThreadnoPhoto($thread){
			$email = $thread->getUserEmail();
			$name = $thread->getName();
			$category = $thread->getCategory();
			$content = $thread->getContent();
			


			$sql = "INSERT INTO thread(name, user_email, category, content)
			VALUES ('$name', '$email', '$category', '$content')";

			//echo $con;
			if( $this->con->query($sql)){

				echo "submission successful";
				
				//require_once __DIR__.'\support\mailer.support.php';

				//$body = $this->getVerificationBody($email);
				//$mailer = new Mailer($email, $this->con, $body);
				//$success = $mailer->sendMail();

				return true;
			}
			else{
				return die("INVALID ERROR: ". mysqli_error($this->con));
			}



		}
	}