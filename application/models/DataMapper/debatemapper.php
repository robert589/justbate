<?php
	class DebateMapper{
		
		private $con;
		function __construct(){
			$db = new DB_CONNECT();
			$this->con = $db->connect();

		}

		function __destruct(){

		}

		function updateVote($vote, $id, $useremail){
		
			//echo $id;
			$sql  = "INSERT INTO debate_user(thread_id, email, yes_no) values($id, '$useremail', $vote)";

			$result = $this->con->query($sql) or die(mysqli_error($this->con));
			return  $result;
		}
	}