<?php

/* @var $this yii\web\View */

use yii\helpers\Html;


?>

     <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        Feeds
                    </a>
                </li>
                <li> 
                    <a href="#">All Activity</a>
                </li>
                <li>
                    <a href="#">Critique</a>
                </li>
                <li>
                    <a href="#">Solution</a>
                </li>
                <li>
                    <a href="#">Proposal</a>
                </li>
                <li>
                    <a href="#">Followers <span class="badge">5</span></a>
                </li>
                <li>
                    <a href="#">Following <span class="badge">5</span></a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->
        <div id="page-content">

        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-3">
                            <img src="girl.jpg" alt="Profile Picture" style="width:180px;height:180px;"> </div>
                            <div class="col-lg-8">
                                <div id="displayName">
                                    <p>Grace Christina</p> <!--need to extract from database-->
                                </div>
                            <div id="displayDetails">
                               <!-- <script type="text/javascript">
                                    function changeThis(){
                                        var formInput = document.getElementById('userDescription').value;
                                        document.getElementById('description').innerHTML = formInput;
                                    }

                                </script>-->
                            <form>
                                <span>Description about yourself: </span><br>
                                <input type='text' id='userDescription' placeholder='Write here' />
                                <input type='submit' onclick='changeThis()' value='Submit'/> 
                                <input type='reset' value='Reset'/> <br>
                                <span id='description'></span>
                                <br><br>
                            </form>
                                <button type="button" class="btn btn-primary">Followers <span class="badge">100</span></button>
                            </div>               
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- /#page-content-wrapper -->
        <div class="well well-sm">
            <h4>Basic Information</h4>      
        </div>
       
        <div class="well well-sm">
            <h4>Contact Information</h4>      
        </div>
        <div class="well well-sm">
            <h4>Additional Information</h4>      
        </div>

    


    </div>
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="../js/script.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>
