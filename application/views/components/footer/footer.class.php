<?php

	class Footer{	

		const GENERAL = 'general.php';
		function __construct(){

		}

		function __destruct(){

		}

		function add($choose){
			if(strcmp($add, GENERAL) === 0){
				include(ROOT . DS. "application" . DS . "views" . DS . "components". DS . "footer" .  GENERAL);
			}
		}

	}