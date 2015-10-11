<?php
	//thread
	require_once __DIR__.'/db_connect.php';

	$db = new DB_CONNECT();
	$con =	$db->connect();

	//USER TABLE
	$sql = "CREATE TABLE user(
		email varchar(255) not null,
		first_name varchar(255) not null,
		last_name varchar(255) not null,
		password varchar(255) not null,
		birthday date not null,
		total_dislike int not null,
		total_like int not null,
		yellow_card boolean not null,
		validated boolean not null,
		primary key(email) ); ";
	$con->query($sql) or die(mysqli_error($con));

	//VALIDATION_CODE TABLE for storing code of validation, the code will be used when
	//user wants to validate
	$sql = "CREATE TABLE validation_code(
		useremail varchar(255) not null,
		code varchar(255) not null,
		primary key(useremail),
		foreign key(useremail) references user(email))";
	$con->query($sql) or die(mysqli_error($con));

	//Forgot_code table is used when user forget their password, they can
	//use temporary password, which is stored in this table
	$sql ="CREATE table forgot_code(
		email varchar(255) not null,
		temporary_password varchar(255) not null,
		primary key(email),
		foreign key(email) references user(email));";
	$con->query($sql) or die(mysqli_error($con));


		//Thread table
	$sql = "CREATE TABLE thread(
		name varchar(255) not null,
		thread_id int not null auto_increment,
		photo varchar(255) null,
		date_created datetime not null,
		user_email varchar(255) not null,
		foreign key(user_email) references user(email),
		primary key(thread_id));";
	
	$con->query($sql) or die(mysqli_error($con));


	//Comment table
	$sql = "CREATE TABLE comment(
		email varchar(255) not null,
		date_created datetime not null,
		comment_id int not null auto_increment,
		comment varchar(255) not null,
		primary key(comment_id),
		foreign key(email) references user(email))";
	$con->query($sql) or die(mysqli_error($con));

	//child comment
	$sql = "CREATE TABLE childcomment(
		parent_comment_id int not null,
		child_comment_id int not null,
		primary key(parent_comment_id, child_comment_id),
		foreign key(parent_comment_id) references comment(comment_id),
		foreign key(child_comment_id) references comment(comment_id))	";

	$con->query($sql) or die(mysqli_error($con));


?>