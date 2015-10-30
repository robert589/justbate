<?php

require_once(ROOT . '/application/controllers/homecontroller.php')	;

$login = checkLogin();

addHeader(Header::GENERAL);

$homecontroller = new HomeController();
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
		<div class="col-xs-5" id="home">
			<?php
				$homecontroller->retrieveNewestThread(1);
			?>
		</div>

	</div>
</div>



