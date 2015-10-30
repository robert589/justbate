 <div class="container-fluid col-xs-12">
			<!--Navigation logo-->
 			<div class="navbar-header col-xs-2">
  
 				<a class="navbar-brand" href="#">
 					<span class="glyphicon glyphicon-star"></span></p>
 				</a>
 
 			</div>
 
 
 			<!-- Navigation Search-->
 
 			<div class="col-xs-6" >
 				<form role="search">
 					<div class="col-xs-1">
 						<ul class="nav navbar-nav">
 							<li class="dropdown">
 								<a class="dropdown-toggle" data-toggle="dropdown" href="#">
 									<span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
 								</a>
 								<ul class="dropdown-menu">
 									<li><a href="#"> Page 1-1 </a></li>
 									<li>	<a href="#"> Page 1-2 </a></li>
 									<li><a href="#"> Page 1-3 </a></li>
 								</ul>
 							</li>
 						</ul>
 					</div>
 					<div class="col-xs-10" id="searchBoxMP">
 						<input type="text" class="form-control" placeholder="Search" >
 					</div>
 					<div class="col-xs-1"   id="btnSubmitMP">
 						<button type="submit" class="btn btn-default">
 							<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
 						</button>
 					</div>
 				</form>
 			</div>
 
 			<!-- Navigation Login-->
 			<div class="col-xs-4">
              <div class="col-xs-4">
             		<a class="btn btn-primary btn-lg" align="center" href="signup.php">Daftar</a>
              </div>
 				<div class="col-xs-4">
 					<!-- The drop down menu -->
 					<ul class="nav navbar-nav pull-right">
 
 						<li class="dropdown">
 							<a class="dropdown-toggle" href="#" data-toggle="dropdown">Masuk <strong class="caret"></strong></a>
 							<div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
 								<!-- Login form here -->
 								<form action="/startUp/login.php" method="post" accept-charset="UTF-8">
 									<input id="user_username" style="margin-bottom: 15px;" type="text" name="email" size="30" placeholder="Email"/>
 									<input id="user_password" style="margin-bottom: 15px;" type="password" name="password" size="30" placeholder="Password"/>
                                  <div class="form-group">
 									<input id="user_remember_me" style="float: left; margin-right: 10px;" type="checkbox" name="user[remember_me]" value="1" />
 									<label class="string optional" for="user_remember_me"> Remember me</label>
                                     <a style="float:right" href="sign_up.php">Daftar</a>
                                  </div>
 									<input class="btn btn-primary" style="clear: left; width: 100%; height: 32px; font-size: 13px;" type="submit" name="commit" value="Sign In" />
 								</form>
 							</div>
 						</li>
 					</ul>
 					<!--<a class="navbar-brand navbar-collapse full" id="loginDropdown" href="#">Masuk</a>-->
 				</div>
 
 				<div class="col-xs-4">
 					<ul class="nav navbar-nav">
 						<li class="dropdown">
 							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
 								<span class="glyphicon glyphicon-globe" aria-hidden="true"></span>
 							</a>
 							<ul class="dropdown-menu">
 								<li><a href="#"> Indonesia </a></li>
 
 							</ul>
 						</li>
 					</ul>
 				</div>
 			</div>
 		</div>
