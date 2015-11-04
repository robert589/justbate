<?php

	require_once(ROOT . DS. "application" . DS . "views" . DS . "components" .DS.  "home" . DS . "threadtemplate.php");
	require_once (".." .  DS . "application" . DS . "models" . DS . "threadmodel.php" );
	require_once (".." .  DS . "application" . DS . "models" . DS . "debatemodel.php" );

	require_once (".." .  DS . "application" . DS . "models" . DS . "DomainObject" . DS . "thread.entity.php" );

	$controller = new HomeController();

	if(isset($_GET['vote']) && isset($_GET['id'])){
		$vote = $_GET['vote'];
		$id = $_GET['id'];

		$controller->userVote($vote, $id);
	}

	class HomeController{

		private $pageRetrieved  ;

		private $threadmodel;

		private $debatemodel;

		function __construct(){
			$this->threadmodel = new ThreadModel();
			$this->debatemodel = new DebateModel();
			$this->pageRetrieved = 0;
		}

		function __destruct(){

		}

		function retrieveNewestThread($numpage){
			$thread = new Thread();
			$thread = $this->threadmodel->retrieveNewestPage($numpage);

			$body = "";
			for($i = 0; $i < count($thread); $i++){
				$name = $thread[$i]->getName();
				$id = $thread[$i]->getId();
  				$body .= $this->template($name, $id);
			}

			echo  $body;
		}

		function userVote($vote, $id){
			$result = checkLogin();
			if($result == true){
				$useremail = retrieveUserEmail();
				$result = $this->debatemodel->addUserVote($vote, $id, $useremail);

				if($result === true){
					header("location: home.php");
				}
				else{
					echo $result;
				}
			}
			else{
				header("location: home.php?message='Please Login First'");
			}
		}




		private function template($name, $id){
			return '<div class="col-xs-12" style="background-color:silver;" >
				<h4>' . $name . '</h4>

					<div class="full">



						<div style="height:20px"></div>

						<div class="col-xs-1">
							<a href="#" class="btn btn-info btn-lg">
								<span class="glyphicon glyphicon-comment"></span> 
							</a>
						</div>


						<div class="col-xs-1">
							<a href="#" class="btn btn-info btn-lg">
								<span class="glyphicon glyphicon-heart"></span> 
							</a>
						</div>

						<div class="col-md-offset-8 col-md-1">
							<a href="homecontroller.php?vote=1&id='.$id.'" class="btn btn-info btn-md">
								<label>Yes</label>
							</a>
						</div>


						<div class=" col-md-1">
							<a href="homeontroller.php?vote=0&id='.$id.'" class="btn btn-info btn-md">
								<label>No</label>
							</a>
						</div>
					</div>
				</div>';
		}
	}