<?php

		require_once(ROOT . DS. "application" . DS . "views" . DS . "components" .DS.  "header" . DS . "header.class.php");
		require_once(ROOT . DS. "application" . DS . "views" . DS . "components". DS . "footer" .  DS . "footer.class.php");
		require_once(ROOT . DS. "application" . DS . "views" . DS . "components". DS . "navbar" .  DS . "navbar.class.php");
		require_once(ROOT . DS. "application" . DS . "views" . DS . "components". DS . "navside" .  DS . "navside.class.php");


		function checkLogin(){
			session_start();
			if(isset($_SESSION['email'])){
				return 1;

			}
			else{
				return 0;
			}

		}


		function addHeader($headerval){
			$header= new Header();
			$header->add($headerval);

		}

		function addNavbar($navbarval){
			$navbar= new Navbar();
			$navbar->add($navbarval);

		}

		function addNavside($navsideval){
			$navside= new Navside();
			$navside->add($navsideval);

		}


