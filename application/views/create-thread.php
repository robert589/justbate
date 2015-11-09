
<?php

require_once(ROOT . '/application/controllers/create-threadcontroller.php')	;

$login = checkLogin();

addHeader(Header::GENERAL);

$threadController = new ThreadController();
?>
<nav class="navbar navbar-default" id="navBar">
	<?php 
	if($login)
		addNavbar(Navbar::AFTER_LOGIN);
	else
		header("Location: login.php");
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
		<div class="col-xs-5" id="create-thread">
			<h1 class="spacer-12"> Create Thread </h1>

				<label class="spacer-12">Jenis Topik</label>

				<form role = "form" class="form" id = "createThreadForm" action = "create-threadcontroller.php" method = "post">
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

						<label> Isi </label>

						<input type="text" class="form-control"  name="content" placeholder="Place topic name here">

					</div>

					<hr>

					<div class="form-group">
						<label for="exampleInputFile">File input</label>
						<input type="file" id="exampleInputFile">
						<p class="help-block">Upload Photo Here</p>
					</div>
                    
                    <hr>
					<input type="submit" name = "addThread" class="btn btn-info spacer-12" style="clear:both" >

					<!--form-group-->
				</form>

		</div>

	</div>
</div>


