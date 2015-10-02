<?php
	class User{

		private $con = NULL;

		private $encoded_code = null;

		function __construct(){
			require_once __DIR__.'/db_connect.php';

			$db = new DB_CONNECT();
			$this->con =	$db->connect();

		}

		function __destruct(){

		}

		function updateValidation($code){

			//SECURITY FAILED: HOW IF THEY USE BRUTE FORCE TO VALIDATE ALL EMAILS
			$sql = "SELECT * from validation_code where code = '$code'";

			$result = $this->con->query($sql);

			if($result->num_rows > 0){
				$result = $result->fetch_assoc();
				$email = $result['useremail'];

				$sql = "UPDATE user SET validated = 1 WHERE email ='$email'";

				if($this->con->query($sql)){
					//DELETE validtion
					$sql = "DELETE FROM validation_code WHERE useremail='$email'";
					if($this->con->query($sql) === true){
						return true;
					}
					else{
						return "Failed to Delete validation_code " . mysqli_error($this->con);
					}
				}
				else{
					return "Failed update the user to validated: ". mysqli_error($this->con);
				}
			}
			else{
				return  "Something wrong in the link: ". mysqli_error($this->con);
			}
		}

		function signUp($email, $first_name, $last_name, $password, $birthday){
			//encode the password using md5
			$password = md5($password);


			$sql = "INSERT INTO user(first_name, email, last_name, password, birthday)
			VALUES ('$first_name', '$email', '$last_name', '$password', '$birthday')";

			//echo $con;
			if( $this->con->query($sql)){
				
				require_once __DIR__.'\Mailer.php';

				$body = $this->getVerificationBody($email);
				$mailer = new Mailer($email, $this->con, $body);
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

		function insertNewValidation($email, $code){
			$sql = "INSERT INTO validation_code(useremail, code) values('$email', '$code')";
			if($this->con->query($sql)){
				return true;
			}	
			else{
				die(mysqli_error($this->con));
			}
		}

		function getVerificationBody($email){



			$verificationCode = $this->createRandomString();

			$this->encoded_code = md5($verificationCode);

			//insert the new validation code to the db
			$this->insertNewValidation($email, $this->encoded_code);

			$verificationLink = "http://192.168.131.1/startUp/activate.php?code=". $this->encoded_code;	

		    $htmlStr = "";
            $htmlStr .= "Hi " . $email . ",<br /><br />";
                 
            $htmlStr .= "Please click the button below to verify your subscription and have access to our website.<br /><br /><br />";
            $htmlStr .= "<a href='". $verificationLink . "' target='_blank' style='padding:1em; font-weight:bold; background-color:blue; color:#fff;'>VERIFY EMAIL</a><br /><br /><br />";
                 
            $htmlStr .= "regards,<br />";
            $htmlStr .= "<a href='http://192.168.131.1/startUp' target='_blank'>People Voice</a><br />";

            return $htmlStr;
		}


	public function createRandomString(){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < 8; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	}
?>