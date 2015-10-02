<?php
		if(isset($_POST["name"]) && isset($_POST["thread_id"])  && isset($_POST["date_created"]) && isset($_POST["user_email"])){

			
			session_start();

			$name = $_SESSION["first_name"];
			//$thread_id = $_POST["thread_id"];
			//$date_created = $_POST["data_created"];
			$user_email = $_SESSION["userEmail"];

		require_once __DIR__.'/php/thread.php';	

		//echo "<script type='text/javascript'>alert('dsds');</script>";
		$newThread = new Thread();

		$valid = false;

		if(isset($_POST['photo'])){
			$photo = $_POST['photo'];
			$valid = $newThread->create_thread($name, $thread_id, $photo, $data_created, $user_email);

	    }
		else{
			$valid = $newThread->create_thread($name, $thread_id, $data_created, $user_email);

		}

		if($valid === true){
			echo "<script type='text/javascript'>alert('New Thread Created');</script>";
		}
		else{
			echo "<script type='text/javascript'>alert('Failed to Create New Thread');</script>";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/manual.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	<title>Homepage</title>
</head>


<body>

	<!-- Navigation Part -->



	<nav class="navbar navbar-default" id="navBar">

	</nav>

	<div class="full">
		<div class="col-xs-12">
			<!--Side Bar-->
			<div class="col-xs-3" id="navSide">
			</div>

			<div class="col-xs-6" id="createThread">

				<h1 class="spacer-12"> Create Thread </h1>

				<label class="spacer-12">Jenis Topik</label>

				<form class="form">
					<div class="form-group col-xs-12 form-inline">

						<div class="col-xs-4">

							<label class="radio-inline ">
								<input id="inlineradio1" name="topic_category" value="Debat" type="radio">
								Debat
							</label>
						</div>
						<div class="col-xs-4">
							<label class="radio-inline ">
								<input id="inlineradio2" name="topic_category" value="Pertanyaan" type="radio">
								Pertanyaan
							</label>
						</div>

						<div class="col-xs-4">

							<label class="radio-inline ">
								<input id="inlineradio3" name="topic_category" value="Petisi" type="radio">
								Petisi 
							</label>
						</div>

						<hr>

					</div>


					<div class="form-group inline-block">

						<label> Nama Topik </label>

						<input type="text" class="form-control"  name="topicName" placeholder="Place topic name here">

					</div>

					<hr>

					<div class="form-group">
						<label for="exampleInputFile">File input</label>
						<input type="file" id="exampleInputFile">
						<p class="help-block">Upload Photo Here</p>
					</div>
                    
                    <hr>
					<input type="submit" class="btn btn-info spacer-12" style="clear:both" >

					<!--form-group-->
				</form>

			</div>
		</div>
	</div>



</div>

<script src="js/startup.js"></script>
</body>
</html>
