<?php


	class UserMapper {

		private $con;

		const EMAIL_NOT_FOUND = "Email NOT Found";

		function __construct(){
			$db = new DB_CONNECT();
			$this->con = $db->connect();
		}

		function __destruct(){

		}


		function login($user){
			//Retrieve data first
			$email = $user->getEmail();
			$password = $user->getPassword();

			//Retrieve password from dataabase
			$real_password = $this->retrieveMD5Password($email);

			if(strcmp($real_password, self::EMAIL_NOT_FOUND) !== 0 ){
				return $real_password;
			}
			else{
				return true;
			}



		}

		function register($user){
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


		}

 		function retrieveUser($username){
			$sql = "SELECT * from user where username = '$username'";

			$result = $this->con->query($sql) or die(mysqli_error($this->con));

			if($result->num_rows > 0){
				return mysqli_fetch_array($result);
			}
			else{
				return false;
			}
		}


 		function retrieveUserWithEmail($email){
			$sql = "SELECT * from user where email = '$email'";

			$result = $this->con->query($sql) or die(mysqli_error($this->con));

			if($result->num_rows > 0){
				return mysqli_fetch_array($result);
			}
			else{
				return false;
			}
		}
		function verifyCode($code){
			$sql = "SELECT * from validation_code where code = '$code'";

			$result = $this->con->query($sql) or die(mysqli_error($this->con));

			if($result->num_rows > 0){
				$cursor = mysqli_fetch_array($result);
				$email = $cursor['useremail'];

				$sql = "UPDATE user SET validated=1 where email = '$email'";

				$result = $this->con->query($sql) or die(mysqli_error($this->con));

				if($result){
					$sql = "DELETE  FROM validation_code where email = '$email'";


					$this->con->query($sql) or die(mysqli_error($this->con));

					header('location: ../Startupapp/home.php?message="Your email has just been verified, ' . $email);
				}
				else{
					header('location: ../Startupapp/home.php?message="Email Not Found"');
				}
			}
			else{
				header('location: ../Startupapp/home.php?message="Broken Verification Link"');
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

		private	function getVerificationBody($email){



			$verificationCode = $this->createRandomString();

			$this->encoded_code = md5($verificationCode);

			//insert the new validation code to the db
			$this->insertNewValidation($email, $this->encoded_code);

			$verificationLink = "http://localhost/Startupapp/registercontroller.php?code=". $this->encoded_code;	

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
		
		private function retrieveMD5Password($email){
			$sql = "SELECT password from user where email = '$email' ";

			$result = $this->con->query($sql) or die(mysqli_error($this->con));
			if($result->num_rows > 0 ){

				$user = mysqli_fetch_array($result);
				return $user['password'];
			}
			else{
				return self::EMAIL_NOT_FOUND;
			}
		}
	}