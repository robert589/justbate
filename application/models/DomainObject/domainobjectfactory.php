<?php
	
	require_once "/user.entity.php";
	require_once "/thread.entity.php";
	class DomainObjectFactory{

		const USER_ENTITY = "user_entity";
		const THREAD_ENTITY = "thread_entity";

		function __construct(){

		}

		function __destruct(){

		}

		function getDomainObject($domainType){
			if(strcmp(self::USER_ENTITY, $domainType)  === 0){
				return new User();
			}
			else if(strcmp(self::THREAD_ENTITY, $domainType)  === 0){
				return new Thread();
			}
		}


	}