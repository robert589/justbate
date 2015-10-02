<?php
require_once __DIR__.'/Mailer.php';
require_once __DIR__.'/db_connect.php';
	//require_once __DIR__.'/ScriptContent';

class ForgotPassword{

	const CHANGE_PASSWORD_LINK = 'http://localhost/startUp/change-password.php';

	private $email = null;

	private $con = null;

	private $temp_password = null;

	function __construct($email){
		$this->email = $email;
		$this->con = (new DB_CONNECT())->connect();

		$this->temp_password = $this->createRandomString();

	//	echo '<script>console.log('.$this->encode_code . ');</script>';
	}

	function __destruct(){

	}

	function perform(){
			//FIRST SEND THE EMAIL
		$valid = $this->updateForgotCode();
		if($valid === true){			
			$mailer = new Mailer($this->email, $this->con, $this->createBody());
			$result = $mailer->sendMail();
			if($result ===true){
				return true;
			}
			else{
				return "FAILED SENDING EMAIL: ". $result;
			}
		}
		else{
			return $valid; 
		};





	}

	function updateForgotCode(){
		$checkEmail = "SELECT * from forgot_code WHERE email = '$this->email'";
		$result = $this->con->query($checkEmail);
		if($result->num_rows > 0){
			$sql = "UPDATE forgot_code SET temporary_password='$this->temp_password' WHERE email = '$this->email'";
		}
		else{
			$sql = "INSERT INTO forgot_code(email, temporary_password) VALUES('$this->email', '$this->temp_password'); ";

		
		}
		$result = $this->con->query($sql);

		if($result === true){
			return true;
		}
		else{
			return 'FAILED TO UPDATE DB ' . mysqli_error($this->con);
		}
		
	}

	function createBody(){


	//	$codeLink = $this->createTheLink();
		

		$htmlStr = "";
		$htmlStr .= "Hi " . $this->email . ",<br /><br />";

		$htmlStr .= "Your Temporary Password is ". $this->temp_password . " <br /><br /><br />";
		$htmlStr .= "<a href='". self::CHANGE_PASSWORD_LINK . "' target='_blank' style='padding:1em; font-weight:bold; background-color:blue; color:#fff;'>CHANGE PASSWORD</a><br /><br /><br />";

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