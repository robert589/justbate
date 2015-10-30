<?php

	class NavBar{
		const BEFORE_LOGIN = 'before-login.php';

		const AFTER_LOGIN = "after-login.php";
		function __construct(){

		}

		function __destruct(){

		}

		function add($choose){
			if(strcmp($choose, self::BEFORE_LOGIN) === 0){
				include(ROOT . DS. "application" . DS . "views" . DS . "components".  DS . "navbar" .  DS.self::BEFORE_LOGIN);
			}
			else if(strcmp($choose, self::AFTER_LOGIN) === 0){
				include(ROOT . DS. "application" . DS . "views" . DS . "components".  DS . "navbar" .  DS.self::AFTER_LOGIN);


			}
			else{

			}
		}

	}