<?php

	//Variable that is accessible
		
	
	
	function redirectPage(){
		global $url;

		//echo $url;
		if(strcmp($url, "") != 0){
			//Seperate the url by "/" to string array
				$urlArray  = explode("/", $url);

			//the first one is the controler or a php file
			$controller = $urlArray[0];

			//echo $controller;
			//No rewriting the rule
			if(strpos($controller, "controller") !== false){
								echo $controller;

				require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . $url);
			}
			else if(strpos($controller, ".php") !== false){							

				include (DS . "baseview" . ".php");
				require_once (ROOT . DS . 'application' . DS. 'views' . DS . $controller);


			}
			else{
				//check whether second one is set

				if(isset($urlArray[1])){
					if(strcmp($urlArray[1], "") != 0){
						require_once (ROOT . DS . 'application' . DS. 'controllers' . DS . $controller . DS . $urlArray[1]);
					}
					else{

						require_once (ROOT . DS . 'application' . DS.'views' . DS . $controller . DS . 'index.php');
					}
				}
				else{
					echo "404 NOT FOUND";
				}
			}
		}
		else{

		}
	}



	redirectPage();