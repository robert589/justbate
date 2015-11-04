<?php

	require_once 'threadmodel.php';

	class DebateModel extends ThreadModel{

		function __construct(){
						parent::__construct();


		}

		function __destruct(){


		}

		function addUserVote($vote, $id, $useremail){
			$mapper = $this->dataMapper->getDataMapper(DataMapperFactory::DEBATE_MAPPER);

				//Add vote to debate
			return $mapper->updateVote($vote,$id,$useremail);
			
		}
	}