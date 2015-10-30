<?php
	require_once 'support/database.php';
	require_once 'usermapper.php';
	require_once 'threadmapper.php';

	class DataMapperFactory{

		const USER_MAPPER = "usermapper";

		const THREAD_MAPPER = "threadmapper";

		function __construct(){

		}

		function __destruct(){

		}

		function getDataMapper($mapperType){
			if(strcmp(self::USER_MAPPER, $mapperType)  === 0){
				
				return new UserMapper();
			}
			else if(strcmp(self::THREAD_MAPPER, $mapperType)  === 0){
				
				return new Threadmapper();
			}
		}


	}