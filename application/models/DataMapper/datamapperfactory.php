<?php
	require_once 'support/database.php';
	require_once 'usermapper.php';
	require_once 'threadmapper.php';
	require_once 'debatemapper.php';
	class DataMapperFactory{

		const USER_MAPPER = "usermapper";

		const THREAD_MAPPER = "threadmapper";

		const DEBATE_MAPPER = "debatemapper";

		const DEBATE_USER_MAPPER = "debateusermapper";
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
			else if(strcmp(self::DEBATE_MAPPER, $mapperType)  === 0){
				
				return new DebateMapper();
			}
			else if(strcmp(self::DEBATE_USER_MAPPER, $mapperType)  === 0){
				
				return new DebateUserMapper();
			}
		}


	}