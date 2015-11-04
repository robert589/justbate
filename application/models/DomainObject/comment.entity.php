<?php

	class Comment{

		private $email;

		private $date_created;

		private $comment;

		private $comment_id;

		private $first_name;

		private $last_name;

		function __construct(){

		}

		function __destruct(){

		}

		function setFirstname($first_name){
			$this->first_name = $first_name;
		}

		function getFirstname(){
			return $this->first_name;
		}

		function setLastName($last_name){
			$this->last_name = $last_name;
		}

		function getLastname(){
			return $this->last_name;
		}
		
		function getFullname(){
			return $this->first_name . ' ' . $this->last_name;
		}
		function setEmail($email){
			$this->email = $email;
		}

		function getEmail(){
			return $this->email;
		}


		function setDateCreated($date_created){
			$this->date_created = $date_created;
		}

		function getDataCreated(){
			return $this->date_created;
		}

		function setComment($comment){
			$this->comment = $comment;
		}

		function getComment(){
			return $this->comment;
		}


		function setID($comment_id){
			$this->comment_id = $comment_id;
		}

		function getID(){
			return $this->comment_id;
		}


	}