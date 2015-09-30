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
			//encode the password using md5
			$password = md5($password);


			$sql = "INSERT INTO user(first_name, email, last_name, password, birthday)
			VALUES ('$first_name', '$email', '$last_name', '$password', '$birthday')";

			//echo $con;
			if( $this->con->query($sql)){
				
				require_once __DIR__.'\Mailer.php';
				$mailer = new Mailer($email, $this->con);
				$success = $mailer->sendMail();

				return $success;
			}
			else{
				return die("INVALID ERROR: ". mysqli_error($this->con));
			}
			

			
		}

		function signUpWOLastNames($email, $first_name, $password, $birthday){
			
		}

		function login($email, $password){
				//encode
				$mdpassword = md5($password);

				$sql = "SELECT * from user where email = '$email' AND password = '$mdpassword'";


				$result = $this->con->query($sql) or die(mysqli_error($con));
				if($result->num_rows > 0){

					return true;
				}
				else{
					//if it fails, check temporary password
					$sql = "SELECT * from forgot_code where email = '$email' and temporary_password = '$password'";
					$result = $this->con->query($sql);
					if($result->num_rows > 0){
						
						return true;
					}
					else{
						return false;
					}
				}
		}

		function retrieveUserData($email){
			$sql = "SELECT * from user where email ='$email'";

			$result = $this->con->query($sql);

				//	$email = $result['email'];
				//echo "<script>alert($email)</script>";
			if($result->num_rows > 0){
				return $result->fetch_assoc();
			}
			else{
				return false;
			}
		}

		function changePassword($email, $oldPassword, $newPassword){
			if($this->login($email, $oldPassword) === true){
				$newPassword = md5($newPassword);
				$sql = "UPDATE user set password = '$newPassword' where email = '$email'";
				if($this->con->query($sql) === true){
					$sql = "DELETE FROM forgot_code where email='$email' ";
					if($this->con->query($sql) === true){
						return true;
					}
					else{
						return "FAILED update forgot_code " . mysqli_error($this->con);
					}
				}
				else{
					return "FAILED update user " . mysqli_error($this->con);
				}
			}
			else{
				return "Password does not match";
			}
		}
	}
?>