<?php

	class NavSide{
		const GENERAL = 'navside.php';


		function __construct(){

		}

		function __destruct(){

		}

		function add($choose){
			if(strcmp($choose, self::GENERAL) === 0){
					include(ROOT . DS. "application" . DS . "views" . DS . "components".  DS . "navside" .  DS . self::GENERAL);
			}
		}

	}