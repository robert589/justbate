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

	if(isset($_GET['liked']) && isset($_GET['id'])){
		$liked = $_GET['liked'];
		$id = $_GET['id'];

		$controller->userCommentLikeDislike($liked, $id);
	}

	if(isset($_GET['action'])){
		$message = $_GET['action'];
		if(strcmp($message, "comment") === 0 ){
			if(isset($_GET['id'])){
				$id = $_GET['id'];
				$controller->retrieveComment($id);
			}
		}
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

		function userCommentLikeDislike($liked, $id){
			$result = checkLogin();
			if($result == true){
				$username = retrieveUsername();
				$result = $this->debatemodel->addUserCommentLikeDislike($liked, $id);

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
							<a href="homecontroller.php?action=comment&id=' . $id. '" class="btn btn-info btn-lg">
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
							<a href="homecontroller.php?vote=0&id='.$id.'" class="btn btn-info btn-md">
								<label>No</label>
							</a>
						</div>
					</div>
				</div>
				'. $this->retrieveComment($id);
		}

		public function retrieveComment($thread_id){

			$commentArray = $this->threadmodel->retrieveComment($thread_id);

			$body = "";



			for($i = 0 ; $i < count($commentArray); $i++){
				$comment_entity = $commentArray[$i];
				$username = $comment_entity->getFullname();
				$comment = $comment_entity->getComment();
				$comment_id = $comment_entity->getID();
				$body .= '<div class="col-xs-12" style="background-color:white;  "> 
					<div class="col-md-10 style="background-color:white; height:100px;">
						<a href="">'. $username . '</a> ' . $comment .'

					</div>
					<div class="col-md-10 style="background-color:white;">
						<a href="homecontroller.php?liked=1&id=' . $comment_id . '">Like</a> 
						<a href="homecontroller.php?liked=0&id=' . $comment_id . '">Dislike</a> 
						<a href="">Reply </a>
					</div>
					</div>' ;
			}

			return $body;
		}

	}