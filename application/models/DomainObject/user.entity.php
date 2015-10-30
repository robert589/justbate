<?php

	class User{

		private $email;

		private $firstName;

		private $lastName;

		private $password;

		private $birthdate;

		private $totalDislike; 

		private $totalLike;

		private $yellow_card;

		private $red_card;
		
	
		function __construct(){

		}

		function __destruct(){
			
		}

		function setFirstName($name){
			$this->firstName = $name;
		}

		function getFirstName(){
			return $this->firstName;
		}

		function setLastName($name){
			$this->lastName = $name;
		}

		function getLastName(){
			return $this->lastName;
		}

		function setEmail($email){
			$this->email = $email;

		}

		function getEmail(){
			return $this->email;
		}

		function setBirthdate($date){
			$this->birthdate = $date;
		}

		function getBirthdate(){
			return $this->birthdate;
		}

		function setPassword($password){
			$this->password = $password;

		}

		function getPassword(){
			return $this->password;
		}

		function setTotalDislike($totalDislike){
			$this->totalDislike = $totalDislike;
		}

		function getTotalDislike(){
			return $this->totalDislike;
		}

		function setTotalLike($totalLike){
			$this->totalDislike = $totalDislike;
		}

		function getTotalLike(){
			return $this->totalLike;
		}


	}