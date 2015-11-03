<?php

	require_once(ROOT . DS. "application" . DS . "views" . DS . "components" .DS.  "home" . DS . "threadtemplate.php");
	require_once (".." .  DS . "application" . DS . "models" . DS . "threadmodel.php" );
	require_once (".." .  DS . "application" . DS . "models" . DS . "DomainObject" . DS . "thread.entity.php" );



	class HomeController{

		private $pageRetrieved  ;

		private $threadmodel;

		function __construct(){
			$this->threadmodel = new ThreadModel();
			$this->pageRetrieved = 0;
		}

		function __destruct(){

		}

		function retrieveNewestThread($numpage){
			$thread = new Thread();
			$thread = $this->threadmodel->retrieveNewestPage($numpage);

			$body = "";
			for($i = 0; $i < count($thread); $i++){
				$body .= $this->template($thread[$i]->getName());
			}

			echo  $body;
		}






		private function template($name){
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
							<a href="#" class="btn btn-info btn-md">
								<label>Yes</label>
							</a>
						</div>


						<div class=" col-md-1">
							<a href="#" class="btn btn-info btn-md">
								<label>No</label>
							</a>*
						</div>
					</div>
				</div>';
		}
	}