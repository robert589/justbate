<?php

	require __DIR__.'/phpmailer/PHPMailerAutoload.php';
	require_once __DIR__.'/database.php';

		
	class Mailer{

		private  $email;

		private $encode_code;

		private $con;

		private $mailer;

		private $body;

		function __construct($new_email, $connection, $body){
			$this->con  = $connection;
			$this->email = $new_email;
			$this->mailer = new PHPMailer;
			$this->body = $body;

		}

		public function sendMail(){

			$this->mailer->isSMTP();
			//$this->mailer->SMTPDebug = 2;
			$this->mailer->SMTPAuth = true;
			$this->mailer->SMPTSecure = "tls";
			$this->mailer->Host = gethostbyname('smtp.gmail.com')		;
			$this->mailer->Port = 587;


			$this->mailer->Username = 'terooka123@gmail.com';
			$this->mailer->Password = 'terookaadmin1';
			
			$this->mailer->isHTML(true);    

			$this->mailer->SetFrom('terooka123@gmail.com');  
			$this->mailer->Body = $this->body;
			$this->mailer->Subject = 'Email Verifikasi';
			$this->mailer->AddAddress($this->email);



			if($this->mailer->Send()){
//					return $this->updateVerificationCode();
				return true;
			} 
			else{
				return "Message was not sent" ;
			}

		}
		/*
		private function createBody(){

			$verificationCode = $this->createRandomString();

			$this->encode_code = md5(uniqid('$randomStr', true));

			$verificationLink = "http://192.168.131.1/startUp/activate.php?code=". $this->encode_code;	

			$htmlStr = "";
            $htmlStr .= "Hi " . $this->email . ",<br /><br />";
                 
            $htmlStr .= "Please click the button below to verify your subscription and have access to our website.<br /><br /><br />";
            $htmlStr .= "<a href='{$verificationLink}' target='_blank' style='padding:1em; font-weight:bold; background-color:blue; color:#fff;'>VERIFY EMAIL</a><br /><br /><br />";
                 
            $htmlStr .= "regards,<br />";
            $htmlStr .= "<a href='http://192.168.131.1/startUp' target='_blank'>Madebygue</a><br />";

            return $htmlStr;
		}
		*/
		/*
		public function createRandomString(){
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    		$charactersLength = strlen($characters);
    		$randomString = '';
    		for ($i = 0; $i < $charactersLength; $i++) {
        		$randomString .= $characters[rand(0, $charactersLength - 1)];
    		}
    		return $randomString;
		}
	*/
		/*
		public function updateVerificationCode(){
			//Retrieve user_id by email
					$sentEmail = $this->email;
					$sql = "INSERT INTO validation_code(code, useremail) VALUES('$this->encode_code', '$sentEmail')";
					if($this->con->query($sql)){
						return true;
					}
						else{
						return "Failed to update the verification code, Please resend the message";
					}
					
		}*/
	}
?>