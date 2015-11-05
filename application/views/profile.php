<?php
require_once(ROOT . '/application/controllers/profilecontroller.php')	;

	$login = checkLogin();
	$username = null;
	if($_GET['user']){
		$username= $_GET['user'];
	}
	else{
		//redirect page
	}		

	addHeader(Header::GENERAL);

	$profilecontroller = new ProfileController();

	$user = $profilecontroller->retrieveUser($username);


?>

<nav class="navbar navbar-default" id="navBar">
	<?php 
	if($login)
		addNavbar(Navbar::AFTER_LOGIN);
	else
		addNavbar(Navbar::BEFORE_LOGIN);
	?>
</nav>

<div class="full">
	<div class="col-xs-12">
		<!--Side Bar-->
		<div class="col-xs-3" id="navSide">
			<?php 
			addNavSide(Navside::GENERAL);
			?>
		</div>
		<div class="col-md-5" id="profile">
			<div class="col-md-12">
				<div class="col-md-4">
					<img src="" alt="Image not found" height="202" width="100">
				</div>
				<div class="col-md-8">
					<h4>Name: <?php echo $user->getFullName()?> </h4> 
					<h4>Birthday: <?php echo $user->getBirthdate()?> </h4> 
					<h4>Like: <?php echo $user->getTotalLike() ?> </h4>
					<h4>Dislike: <?php echo $user->getTotalDislike() ?> </h4>
				</div>
				<div class="col-md-8" float:right>
					<a href="editprofile.php"
				</div>
			</div>
			<div class="col-md-12">
				<h2>Forum Activity</h2>
			</div>
		</div>

	</div>
</div>


	

