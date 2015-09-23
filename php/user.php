<?php
	class User{

		private $con = NULL;


		function __construct(){
			require_once __DIR__.'/db_connect.php';

			$db = new DB_CONNECT();
			$this->con =	$db->connect();

		}

		function __destruct(){

		}

		function signUp($email, $first_name, $last_name, $password, $birthday){
			
			$sql = "INSERT INTO user(first_name, email, last_name, password, birthday)
			VALUES ('$first_name', '$email', '$last_name', '$password', '$birthday')";

			//echo $con;
			if( $this->con->query($sql)){
				return true;
			}
			else{
				return die("INVALID ERROR: ". mysqli_error($this->con));
			}
			

			
		}

		function signUpWOLastNames($email, $first_name, $password, $birthday){
			
		}

		function login($email, $password){
				$sql = "SELECT * from user where email = '$email' AND password = '$password'";

				$result = $this->con->query($sql) or die(mysqli_error($con));
				if($result->num_rows > 0){
					return true;
				}
				else{
					return false;
				}
		}

		function retrieveUserData($email){
				$sql = "SELECT * from user where email ='$email'";

				$result = $this->con->query($sql) or die(mysqli_error($con));

				if($result->num_rows > 0){
					return $result;
				}
				else{
					return false;
				}
		}
	}
?>