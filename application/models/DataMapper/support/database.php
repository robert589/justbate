<?php

	require_once 'dbconfig.php';
	
	class DB_CONNECT{
	//constructor

		private $con = NULL;

		function __construct(){
			$this->connect();
		}

		//destructor
		function __destruct(){
			$this->close();
		}

		function connect(){
			//require_once __DIR__."/db_config.php";

			$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			
			if($con->connect_error){
				die("Connection failed: " . $con->connect_error);
			}

			
 			

			return $con;

		}

		function close(){
			if(isset($con)){
				mysqli_close($con);
			}
		}

	}
?>