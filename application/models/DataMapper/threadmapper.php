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
	}