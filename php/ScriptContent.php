<?php

	class ScriptContent{

		function getVerificationBody($email, $verificationLink){

		$htmlStr = "";
            $htmlStr .= "Hi " . $email . ",<br /><br />";
                 
            $htmlStr .= "Please click the button below to verify your subscription and have access to our website.<br /><br /><br />";
            $htmlStr .= "<a href='". $verificationLink . " target='_blank' style='padding:1em; font-weight:bold; background-color:blue; color:#fff;'>VERIFY EMAIL</a><br /><br /><br />";
                 
            $htmlStr .= "regards,<br />";
            $htmlStr .= "<a href='http://192.168.131.1/startUp' target='_blank'>People Voice</a><br />";

            return $htmlStr;
		}

	}
?>