<?php
	

	class Thread{
		private $name;

		private $thread_id;

		private $photo;

		private $date_created;

		private $user_email;


		function __construct(){

		}

		function __destruct(){

		}

		function setName($name){
			$this->name = $name;
		}

		function getName(){
			return $this->name;
		}


		function setID($name){
			$this->thread_id = $thread_id;
		}

		function getID(){
			return $this->thread_id;
		}


		function setPhoto($photo){
			$this->photo = $photo;
		}

		function getPhoto(){
			return $this->photo;
		}


		function setDateCreated($date_created){
			$this->date_created = $date_created;
		}

		function getDateCreated(){
			return $this->date_created;
		}


		function setUserEmail($user_email){
			$this->user_email = $user_email;
		}

		function getUserEmail(){
			return $this->user_email;
		}
	}