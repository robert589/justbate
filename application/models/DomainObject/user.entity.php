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
		
		private $username;
	
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

		function setUsername($username){
			$this->username = $username;
		}


		function getFullName(){
			return $this->firstName . ' ' . $this->lastName;
		}
		function getUsername(){
			return $this->username;
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
			$this->totalLike = $totalLike;
		}

		function getTotalLike(){
			return $this->totalLike;
		}

		function setYellowCard($card){
			return $this->yellow_card = $card;
		}

		function getYellowCard(){
			return $this->yellow_card ;	
		}

		function setRedCard($card){
			return $this->red_card = $card;
		}

		function getRedCard(){
			return $this->red_card ;	
		}
	}